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
use App\Models\User;

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
            $categories = ClassifiedCategory::where('status', 1)->orderBy('category','asc')->pluck('category', 'id');
            $classified = Classified::with('postedBy', 'classifiedCategory');
            // Inactive user checkbox is selected
            if ($request->category) {
                if ($request->get('category') == 'active') {
                    $classified = Classified::with('postedBy', 'classifiedCategory')->whereHas('classifiedCategory', function($query) use($request) {
                        $query->where('status', 1);
                    });
                } else {
                    $classified = Classified::with('postedBy', 'classifiedCategory')->whereHas('classifiedCategory', function($query) use($request) {
                        $query->where('status', 0);
                    });
                }
            }

            $classified = $classified->whereHas('postedBy', function($query) use($request) {
                $query->where('title', 'LIKE', '%'.$request->get('item'). '%')                                
                ->where('users.first_name', 'LIKE' , '%'.$request->get('posted_by').'%')
                ->orWhere('users.last_name', 'LIKE' , '%'.$request->get('posted_by').'%');
            });

            if ($request->status) {
                $classified = $classified->where('status', $request->get('status'))->get();
            } else {
                $classified = $classified->get();
            }

            if (count($classified)) {
                Log::info('Classified item displayed successfully.');
                return $this->sendResponse(['categories' => $categories, 'classified' => $classified], 'Classified item retrieved successfully.');
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
    public function create(Request $request)
    {
        try {
            $categories = ClassifiedCategory::where('status', 1)->orderBy('category','asc')->pluck('category', 'id');
            $users = User::where('status', 1)->where('first_name', 'LIKE' , '%'.$request->get('name').'%')
            ->where('last_name', 'LIKE' , '%'.$request->get('name').'%')
            ->where('address', 'LIKE' , '%'.$request->get('address').'%')
            ->where('email', 'LIKE' , '%'.$request->get('email').'%')
            ->where('mobile_no', 'LIKE' , '%'.$request->get('phone').'%')->get();

            if (count($categories) && count($users)) {
                Log::info('Classified categories displayed successfully.');
                return $this->sendResponse(['categories' => $categories, 'users' =>  $users], 'Classified categories retrieved successfully.');
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
            // Active status
            if ($request->active_status) {
                if ($request->get('active_status') == 'yes') {
                    $input['active_status'] == 1;
                } else {
                    $input['active_status'] == 0;
                }
            }
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
            $classified = Classified::find($id);
            if ($classified) {
                Log::info('Showing classified item for item id: '.$id);
                return $this->sendResponse($classified, 'Classified item retrieved successfully.');
            } else {
                return $this->sendError('Classified data not found.');     
            }
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
            $classified = Classified::find($id);
            if ($classified) {
                Log::info('Retrieved classified item to edit for item id: '.$id);
                return $this->sendResponse($classified, 'Classified item retrieved successfully.');
            } else {
                return $this->sendError('Classified data not found.');     
            }
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
            $classified = Classified::find($id);
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
            $classified = Classified::find($id);
            if ($classified) {
                // Delete old images
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

    /**
     * Remove the resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        try {
            $ids = $request->ids;
            $classifieds = Classified::whereIn('id',explode(",",$ids))->get();
            if ($classifieds) {
                foreach ($classifieds as $classified) {
                    // Delete images
                    if ($classified->classifiedImages()) {
                        foreach ($classified->classifiedImages as $file) {
                            if (file_exists(storage_path('app/'.$file->file_path))) { 
                                unlink(storage_path('app/'.$file->file_path));
                            }
                        }
                        $classified->classifiedImages()->delete();
                    }
                    $classified->delete();
                }
                Log::info('Selected classifieds deleted successfully');
                return $this->sendResponse([], 'Selected classifieds deleted successfully.');
            } else {
                return $this->sendError('Classifieds not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete classifieds due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete classifieds.');
        }
    }
}
