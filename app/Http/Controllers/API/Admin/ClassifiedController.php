<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Classified;
use App\Models\ClassifiedImage;
use App\Models\ClassifiedCategory;
use App\Models\ClassifiedCondition;
use App\Http\Resources\Classified as ClassifiedResource;
use App\Http\Requests\StoreClassifiedRequest; 

class ClassifiedController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $categories = ClassifiedCategory::where('status',1)->orderBy('category','asc')->get();

            $classified = Classified::where('title', 'LIKE', '%'.$request->get('item'). '%')
                ->where('classified_category_id', 'LIKE' , '%'.$request->get('category').'%')
                ->where('posted_by', 'LIKE' , '%'.$request->get('posted_by').'%')
                ->where('status', 'LIKE' , '%'.$request->get('status').'%')->get();

            if (count($classified)) {
                Log::info('Classified item displayed successfully.');
                return $this->sendResponse([$categories, $classified], 'Classified item retrieved successfully.');
            } else {
                return $this->sendError('No data found for classified item.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve classified item due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve classified item.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $categories = ClassifiedCategory::where('status',1)->orderBy('category','asc')->get();
            if (count($categories)) {
                Log::info('Classified categories displayed successfully.');
                return $this->sendResponse($categories, 'Classified categories retrieved successfully.');
            } else {
                return $this->sendError('No data found for classified categories.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve classified categories due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve classified categories.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClassifiedRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $classified = Classified::create($input);
            if ($classified) {
                if ($request->hasFile('images')) {
                    $folder = 'classified_images';
                    $input = $request->images;
                    $files = $request->file('images');
                    $this->fileUpload($folder, $input, $files, $classified);
                }
            } else {
                return $this->sendError('Failed to add classified item.');     
            }
            Log::info('Classified item added successfully.');
            return $this->sendResponse($classified, 'Classified item added successfully.');
        } catch (Exception $e) {
            Log::error('Failed to add classified item due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add classified item.');
        }
    }

    /**
     * File upload for classified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $input, $files, $classified)
    {
        try {
            $allowedfileExtension = ['pdf','jpg','jpeg','png','xlsx','bmp'];
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                if($check) {
                    foreach((array)$input as $mediaFiles) {
                        $name = $mediaFiles->getClientOriginalName();
                        $filename = $classified->id.'-'.$name;
                        $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                        $ext  =  $mediaFiles->getClientOriginalExtension();
                        //store image file into directory and db
                        $classifiedImages = new classifiedImage();
                        $classifiedImages->classified_id = $classified->id;
                        $classifiedImages->file_path = $path;
                        $classifiedImages->save();
                    }
                } else {
                    return $this->sendError('invalid_file_format'); 
                }
                Log::info('File uploaded successfully.');
                return response()->json(['file uploaded'], 200);
            }
        } catch (Exception $e) {
            Log::error('Failed to upload classified images due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload classified images.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $classified = Classified::findOrFail($id);
            Log::info('Showing classified item for item id: '.$id);
            return $this->sendResponse($classified, 'Classified item retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve classified item due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve classified item, item not found.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $classified = Classified::findOrFail($id);
            Log::info('Retrieved classified item to edit for item id: '.$id);
            return $this->sendResponse($classified, 'Classified item retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit classified item due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit classified item, item not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreClassifiedRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $classified = Classified::findOrFail($id);
            if ($classified) {
                $update = $classified->fill($input)->save();
                if ($update) {
                    if ($request->hasFile('images')) {
                        //Delete old images to upload new
                        if ($classified->classifiedImages()) {
                            foreach ($classified->classifiedImages as $file) {
                                if (file_exists(storage_path('app/'.$file->file_path))) { 
                                    unlink(storage_path('app/'.$file->file_path));
                                }
                            }
                            $classified->classifiedImages()->delete();
                        }
                        //Add new images
                        $folder = 'classified_images';
                        $input = $request->images;
                        $files = $request->file('images');
                        $this->fileUpload($folder, $input, $files, $classified);
                    }
                    Log::info('Classified item updated successfully for item id: '.$id);
                    return $this->sendResponse([], 'Classified item updated successfully.');
                } else {
                    return $this->sendError('Failed to update classified item.');
                }
            } else {
                return $this->sendError('Classified item not found.');      
            }
        } catch (Exception $e) {
            Log::error('Failed to update classified item due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update classified item.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $classified = Classified::findOrFail($id);
            if ($classified) {
                //Delete old images to upload new
                if ($classified->classifiedImages()) {
                    foreach ($classified->classifiedImages as $file) {
                        if (file_exists(storage_path('app/'.$file->file_path))) { 
                            unlink(storage_path('app/'.$file->file_path));
                        }
                    }
                    $classified->classifiedImages()->delete();
                }
                $classified->delete();
                Log::info('Classified item deleted successfully for item id: '.$id);
                return $this->sendResponse([], 'Classified item deleted successfully.');
            } else {
                return $this->sendError('Classified item not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete classified item due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete classified item.');
        }
    }
}
