<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Ammenity;
use App\Models\AmmenityDocument;
use App\Http\Resources\Ammenity as AmmenityResource;
use App\Http\Requests\StoreAmmenityRequest;

class AmmenityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $ammenities = Ammenity::with('ammenityDocuments')->where('title', 'LIKE', '%'.$request->get('title'). '%')->get();
            if (count($ammenities)) {
                Log::info('Displayed ammenities data successfully.');
                return $this->sendResponse(new AmmenityResource($ammenities), 'Ammenity retrieved successfully.');
            } else {
                return $this->sendError('No data found for ammenities data.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve ammenities data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve ammenities data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAmmenityRequest $request)
    {
        try {
            $input = $request->all();
            $ammenity = Ammenity::create($input);
            if ($ammenity) {
                if ($request->hasFile('ammenity_document')) {
                    $folder = 'ammenity_documents';
                    $fileInput = $request->ammenity_document;
                    $files = $request->file('ammenity_document');
                    $this->fileUpload($folder, $fileInput, $files, $ammenity, $input);
                }
                Log::info('Ammenity added successfully');
                return $this->sendResponse(new AmmenityResource($ammenity), 'Ammenity add successfully.');
            } else {
                return $this->sendError('Failed to add ammenity.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add ammenity due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add ammenity.');
        }
    }

    /**
     * File upload for ticket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $fileInput, $files, $ammenity, $input)
    {
        try {
            $allowedfileExtension = ['pdf','jpg','jpeg','png','xlsx','bmp'];
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                if ($check) {
                    foreach((array)$fileInput as $mediaFiles) {
                        $name = $mediaFiles->getClientOriginalName();
                        $filename = $ammenity->id.'-'.$name;
                        $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                        $ext  =  $mediaFiles->getClientOriginalExtension();
                        //store image file into directory and db
                        $ammenityDocuments = new AmmenityDocument();
                        $ammenityDocuments->ammenity_id = $ammenity->id;
                        $ammenityDocuments->file_type = $input['document_type'];
                        $ammenityDocuments->file_path = $path;
                        $ammenityDocuments->status = 1;
                        $ammenityDocuments->save();
                    }
                } else {
                    return $this->sendError('invalid_file_format'); 
                }
                Log::info('File uploaded successfully.');
                return response()->json(['file uploaded'], 200);
            }
        } catch (Exception $e) {
            Log::error('Failed to upload ammenity documents due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload ammenity documents.');
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
            $ammenity = Ammenity::findOrFail($id);
            Log::info('Showing ammenity for ammenity id: '.$id);
            return $this->sendResponse(new AmmenityResource($ammenity), 'Ammenity retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve ammenity due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve ammenity, ammenity not found.');
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
            $ammenity = Ammenity::findOrFail($id);
            Log::info('retrieved ammenity to edit for ammenity id: '.$id);
            return $this->sendResponse(new AmmenityResource($ammenity), 'Ammenity retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit ammenity due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit ammenity, ammenity not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAmmenityRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $ammenity = Ammenity::findOrFail($id);
            if ($ammenity) {
                $update = $ammenity->fill($input)->save();
                if ($update) {
                    if ($request->hasFile('ammenity_document')) {
                        //Delete old images to upload new
                        if ($ammenity->ammenityDocuments()) {
                            foreach ($ammenity->ammenityDocuments as $file) {
                                if (file_exists(storage_path('app/'.$file->file_path))) { 
                                    unlink(storage_path('app/'.$file->file_path));
                                }
                            }
                            $ammenity->ammenityDocuments()->delete();
                        }
                        //Add new images
                        $folder = 'ammenity_documents';
                        $fileInput = $request->ammenity_document;
                        $files = $request->file('ammenity_document');
                        $this->fileUpload($folder, $fileInput, $files, $ammenity, $input);
                    }
                    Log::info('Ammenity updated successfully for ammenity id: '.$id);
                    return $this->sendResponse([], 'Ammenity updated successfully.');
                } else {
                    return $this->sendError('Failed to update ammenity.');     
                }
            } else{
                return $this->sendError('Ammenity data not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update ammenity due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Opeartion failed to update ammenity.');
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
            $message = 'Ammenity does not found! Please try again.'; 
            $ammenity = Ammenity::findOrFail($id);
            if ($ammenity) {
                $message = 'Cannot delete ammenity, ammenity is assigned to the reservation!';
                if (!$ammenity->reservations->count()) {
                    // To delete related documents
                    if ($ammenity->ammenityDocuments()) {
                        foreach ($ammenity->ammenityDocuments as $file) {
                            if (file_exists(storage_path('app/'.$file->file_path))) { 
                                unlink(storage_path('app/'.$file->file_path));
                            }
                        }
                        $ammenity->ammenityDocuments()->delete();
                    }
                    $ammenity->delete();
                    Log::info('Ammenity deleted successfully for ammenity id: '.$id);
                    return $this->sendResponse([], 'Ammenity deleted successfully.');
                }
                return $this->sendError($message);
            }
        } catch (Exception $e) {
            Log::error($message.'-'. $e->getMessage());
            return $this->sendError($message);
        }
    }
}
