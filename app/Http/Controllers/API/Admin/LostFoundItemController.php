<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Category;
use App\Models\LostFoundItem;
use App\Models\LostFoundItemImage;
use App\Http\Resources\LostFoundItem as LostFoundItemResource;
use App\Http\Requests\StoreLostFoundItemRequest;

class LostFoundItemController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $categories = Category::where('is_hidden', 0)
                                    ->orderBy('category', 'ASC')
                                    ->get();

            $lostItem = LostFoundItem::whereHas('lostFoundItemImages', function ($query) use($request) {
                $query->where('item_title', 'LIKE', '%'.$request->get('title'). '%')
                ->where('created_at', 'LIKE' , '%'.$request->get('date').'%')
                ->where('item_type', 'LIKE' , '%'.$request->get('type').'%')
                ->where('category_id', 'LIKE' , '%'.$request->get('category').'%')
                ->where('status', 'LIKE' , '%'.$request->get('status').'%');
            })->get();

            if (count($categories)) {
                if (count($lostItem)) {
                    Log::info('Lost-found-item data displayed successfully.');
                    return $this->sendResponse([$categories, $lostItem], 'Lost-found-item data retrieved successfully.');
                } else {
                    return $this->sendError('No data found for lost-found-item.');
                }
            } else {
                return $this->sendError('No data found for categories.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve lost-found-item data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve lost-found-item data.');
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
            $categories = Category::where('is_hidden', 0)
                                ->orderBy('category', 'ASC')
                                ->get();
            Log::info('Categories displayed successfully.');
            return $this->sendResponse($$categories, 'Categories retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve categories data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve categories data, categories not found.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLostFoundItemRequest $request)
    {
        try {
            $input = $request->all();
            $lostFoundItem = LostFoundItem::create($input);
            if ($lostFoundItem) {
                if ($request->hasFile('photo')) {
                    $folder = 'lost_item_photos';
                    $input = $request->photo;
                    $files = $request->file('photo');
                    $this->fileUpload($folder, $input, $files, $lostFoundItem);
                }
                Log::info('Lost-found-item added successfully.');
                return $this->sendResponse(new LostFoundItemResource($lostFoundItem), 'Lost-found-item added successfully.');
            } else {
                return $this->sendError('Failed to add lost-found-item');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add lost-found-item due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add lost-found-item.');
        }
    }

    /**
     * File upload for Pet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $input, $files, $lostFoundItem)
    {
        try {
            $allowedfileExtension = ['pdf','jpg','jpeg','png','xlsx','bmp'];
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                if($check) {
                    foreach((array)$input as $mediaFiles) {
                        $name = $mediaFiles->getClientOriginalName();
                        $filename = $lostFoundItem->id.'-'.$name;
                        $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                        $ext  =  $mediaFiles->getClientOriginalExtension();
                        //store image file into directory and db
                        $lostItemimages = new LostFoundItemImage();
                        $lostItemimages->lost_found_item_id = $lostFoundItem->id;
                        // $lostItemimages->file_type = $ext;
                        $lostItemimages->file_path = $path;
                        $lostItemimages->save();
                    }
                } else {
                    return $this->sendError('invalid_file_format'); 
                }
                Log::info('File uploaded successfully.');
                return response()->json(['file uploaded'], 200);
            }
        } catch (Exception $e) {
            Log::error('Failed to upload lost-found-item images due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload lost-found-item images.');
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
            $lostFoundItem = LostFoundItem::findOrFail($id);
            Log::info('Showing lost-found-item data for lost-found-item id: '.$id);
            return $this->sendResponse(new LostFoundItemResource($lostFoundItem), 'Lost-found-item retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve lost-found-item data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve lost-found-item data, lost-found-item not found.');
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
            $lostFoundItem = LostFoundItem::findOrFail($id);
            Log::info('Edit lost-found-item data for lost-found-item id: '.$id);
            return $this->sendResponse(new LostFoundItemResource($lostFoundItem), 'Lost-found-item retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit lost-found-item data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit lost-found-item data, lost-found-item not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLostFoundItemRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $lostFoundItem = LostFoundItem::findOrFail($id);
            if ($lostFoundItem) {
                $update = $lostFoundItem->fill($input)->save();
                if ($update) {
                    if ($request->hasFile('photo')) {
                        //Delete old images to upload new
                        if ($lostFoundItem->lostFoundItemImages()) {
                            foreach ($lostFoundItem->lostFoundItemImages as $file) {
                                if (file_exists(storage_path('app/'.$file->file_path))) { 
                                    unlink(storage_path('app/'.$file->file_path));
                                }
                            }
                            $lostFoundItem->lostFoundItemImages()->delete();
                        }
                        //Add new images
                        $folder = 'lost_item_photos';
                        $input = $request->photo;
                        $files = $request->file('photo');
                        $this->fileUpload($folder, $input, $files, $lostFoundItem);
                    }
                    Log::info('Item updated successfully for item id: '.$id);
                    return $this->sendResponse([], 'Item updated successfully.');
                } else {
                    return $this->sendError('Failed to update item');     
                }
            } else {
                return $this->sendError('Item not found.');      
            }
        } catch (Exception $e) {
            Log::error('Failed to update item due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update item.');
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
            $lostFoundItem = LostFoundItem::findOrFail($id);
            if ($lostFoundItem) {
                if ($lostFoundItem->lostFoundItemImages()) {
                    foreach ($lostFoundItem->lostFoundItemImages as $file) {
                        if (file_exists(storage_path('app/'.$file->file_path))) { 
                            unlink(storage_path('app/'.$file->file_path));
                        }
                    }
                    $lostFoundItem->lostFoundItemImages()->delete();
                }
                $lostFoundItem->delete();
                Log::info('Item deleted successfully for item id: '.$id);
                return $this->sendResponse([], 'Item deleted successfully.');
            } else {
                return $this->sendError('Item not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete item due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete item.');
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
            $lostFoundItem = LostFoundItem::whereIn('id',explode(",",$ids))->get();
            if ($lostFoundItem) {
                foreach ($lostFoundItem as $item) {
                    if ($item->lostFoundItemImages()) {
                        foreach ($item->lostFoundItemImages as $file) {
                            if (file_exists(storage_path('app/'.$file->file_path))) { 
                                unlink(storage_path('app/'.$file->file_path));
                            }
                        }
                        $item->lostFoundItemImages()->delete();
                    }
                    $item->delete();
                }
                Log::info('Selected items deleted successfully');
                return $this->sendResponse([], 'Selected items deleted successfully.');
            } else {
                return $this->sendError('Items not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete acc-requests due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete acc-requests.');
        }
    }

}
