<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Amenity;
use App\Models\AmenityDocument;
use App\Models\DocumentCategory;
use App\Http\Resources\Amenity as AmenityResource;
use App\Http\Requests\StoreAmenityRequest;

class AmenityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $amenities = Amenity::with('amenityDocuments')->where('title', 'LIKE', '%'.$request->title. '%')->get();
            if (count($amenities)) {
                Log::info('Displayed amenities data successfully.');
                return $this->sendResponse(['amenities' => $amenities], 'Amenity retrieved successfully.');
            } else {
                return $this->sendError('No data found for amenities data.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve amenities data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve amenities data.');
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
            $docCategories = DocumentCategory::orderBy('title','asc')->get();

            if (count($docCategories)) {
                Log::info('Document categories displayed successfully.');
                return $this->sendResponse(['docCategories' =>  $docCategories], 'Document categories retrieved successfully.');
            } else {
                return $this->sendError('No data found for document categories.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve document categories due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve document categories.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAmenityRequest $request)
    {
        //try {
            $input = $request->all();
            $amenity = Amenity::create($input);
            if ($amenity) {
                if ($request->hasFile('amenity_document')) {
                    $folder = 'amenity_documents';
                    $fileInput = $request->amenity_document;
                    $files = $request->file('amenity_document');
                    $this->fileUpload($folder, $fileInput, $files, $amenity, $input);
                }
                Log::info('Amenity added successfully');
                return $this->sendResponse(new AmenityResource($amenity), 'Amenity add successfully.');
            } else {
                return $this->sendError('Failed to add amenity.');     
            }
        // } catch (Exception $e) {
        //     Log::error('Failed to add amenity due to occurance of this exception'.'-'. $e->getMessage());
        //     return $this->sendError('Operation failed to add amenity.');
        // }
    }

    /**
     * File upload for ticket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $fileInput, $files, $amenity, $input)
    {
        try {
            $allowedfileExtension = ['pdf','jpg','jpeg','png','xlsx','bmp'];
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                if ($check) {
                    foreach((array)$fileInput as $mediaFiles) {
                        $name = $mediaFiles->getClientOriginalName();
                        $filename = $amenity->id.'-'.$name;
                        $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                        $ext  =  $mediaFiles->getClientOriginalExtension();
                        //store image file into directory and db
                        $amenityDocuments = new AmenityDocument();
                        $amenityDocuments->amenity_id = $amenity->id;
                        $amenityDocuments->file_type = $input['document_type'];
                        $amenityDocuments->file_path = $path;
                        $amenityDocuments->status = 1;
                        $amenityDocuments->save();
                    }
                } else {
                    return $this->sendError('invalid_file_format'); 
                }
                Log::info('File uploaded successfully.');
                return response()->json(['file uploaded'], 200);
            }
        } catch (Exception $e) {
            Log::error('Failed to upload amenity documents due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload amenity documents.');
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
            $amenity = Amenity::findOrFail($id);
            Log::info('Showing amenity for amenity id: '.$id);
            return $this->sendResponse(new AmenityResource($amenity), 'Amenity retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve amenity due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve amenity, amenity not found.');
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
            $amenity = Amenity::findOrFail($id);
            Log::info('retrieved amenity to edit for amenity id: '.$id);
            return $this->sendResponse(['amenity' => $amenity], 'Amenity retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit amenity due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit amenity, amenity not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAmenityRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $amenity = Amenity::findOrFail($id);
            if ($amenity) {
                $update = $amenity->fill($input)->save();
                if ($update) {
                    if ($request->hasFile('amenity_document')) {
                        //Delete old images to upload new
                        if ($amenity->amenityDocuments()) {
                            foreach ($amenity->amenityDocuments as $file) {
                                if (file_exists(storage_path('app/'.$file->file_path))) { 
                                    unlink(storage_path('app/'.$file->file_path));
                                }
                            }
                            $amenity->amenityDocuments()->delete();
                        }
                        //Add new images
                        $folder = 'amenity_documents';
                        $fileInput = $request->amenity_document;
                        $files = $request->file('amenity_document');
                        $this->fileUpload($folder, $fileInput, $files, $amenity, $input);
                    }
                    Log::info('Amenity updated successfully for amenity id: '.$id);
                    return $this->sendResponse([], 'Amenity updated successfully.');
                } else {
                    return $this->sendError('Failed to update amenity.');     
                }
            } else{
                return $this->sendError('Amenity data not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update amenity due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Opeartion failed to update amenity.');
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
            $message = 'Amenity does not found! Please try again.'; 
            $amenity = Amenity::findOrFail($id);
            if ($amenity) {
                $message = 'Cannot delete amenity, amenity is assigned to the reservation!';
                if (!$amenity->reservations->count()) {
                    // To delete related documents
                    if ($amenity->amenityDocuments()) {
                        foreach ($amenity->amenityDocuments as $file) {
                            if (file_exists(storage_path('app/'.$file->file_path))) { 
                                unlink(storage_path('app/'.$file->file_path));
                            }
                        }
                        $amenity->amenityDocuments()->delete();
                    }
                    $amenity->delete();
                    Log::info('Amenity deleted successfully for amenity id: '.$id);
                    return $this->sendResponse([], 'Amenity deleted successfully.');
                }
                return $this->sendError($message);
            }
        } catch (Exception $e) {
            Log::error($message.'-'. $e->getMessage());
            return $this->sendError($message);
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
            $ids = $request->id;
            $amenities = Amenity::whereIn('id',explode(",",$ids))->get();
            // print_r($amenities);
            // die;
            if (count($amenities)) {
                foreach ($amenities as $amenity) {
                        // To delete related documents
                        if ($amenity->amenityDocuments()) {
                            foreach ($amenity->amenityDocuments as $file) {
                                if (file_exists(storage_path('app/'.$file->file_path))) { 
                                    unlink(storage_path('app/'.$file->file_path));
                                }
                            }
                            $amenity->amenityDocuments()->delete();
                        }
                        $amenity->delete();
                    }
                    Log::info('Selected amenities deleted successfully');
                    return $this->sendResponse([], 'Selected amenities deleted successfully.');
            } else {
                return $this->sendError('amenities not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete amenities due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete amenities.');
        }
    }
}
