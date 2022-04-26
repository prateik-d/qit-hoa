<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Committee;
use App\Models\CommitteePhoto;
use App\Models\CommitteeMember;
use App\Http\Resources\Committee as CommitteeResource;
use App\Http\Requests\StoreCommitteeRequest;

class CommitteeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $committee = Committee::where('title', 'LIKE', '%'.$request->get('title'). '%')
                ->where('created_at', 'LIKE' , '%'.$request->get('date').'%')
                ->where('status', 'LIKE' , '%'.$request->get('status').'%')->get();

            if (count($committee)) {
                Log::info('Committee data displayed successfully.');
                return $this->sendResponse(CommitteeResource::collection($committee), 'Committees data retrieved successfully.');
            } else {
                return $this->sendError('No data found for committee.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve committee data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve committee data.');
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
    public function store(StoreCommitteeRequest $request)
    {
        try {
            $input = $request->all();
            $input['added_by'] = Auth::guard('api')->user()->id;
            $committee = Committee::create($input);
            $members = $input['user_id'];
            if (count($members)) {
                $committee->members()->attach($members);
            }
            if ($committee) {
                if ($request->hasFile('committee_photos')) {
                    $folder = 'committee_photos';
                    $input = $request->committee_photos;
                    $files = $request->file('committee_photos');
                    $this->fileUpload($folder, $input, $files, $committee);
                }
                Log::info('Committee created successfully.');
                return $this->sendResponse(new CommitteeResource($committee), 'Committee created successfully.');
            } else {
                return $this->sendError('Failed to create committee.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to create committee due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to create committee.');
        }
    }

    /**
     * File upload for ACC Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $input, $files, $committee)
    {
        try {
            $allowedfileExtension=['pdf','jpg','png','xlsx'];
            foreach ($files as $file) {      
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                if($check) {
                    foreach((array)$input as $mediaFiles) {
                        $name = $mediaFiles->getClientOriginalName();
                        $filename = $committee->id.'-'.$name;
                        $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                        $ext  =  $mediaFiles->getClientOriginalExtension();
                        //store image file into directory and db
                        $committeePhoto = new CommitteePhoto();
                        $committeePhoto->committee_id = $committee->id;
                        $committeePhoto->file_path = $path;
                        $committeePhoto->save();
                    }
                } else {
                    return $this->sendError('invalid_file_format'); 
                }
                Log::info('File uploaded successfully.');
                return response()->json(['file uploaded'], 200);
            }
        } catch (Exception $e) {
            Log::error('Failed to upload committee photos due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload committee photos.');
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
            $committee = Committee::findOrFail($id);
            Log::info('Showing committee data for committee id: '.$id);
            return $this->sendResponse(new CommitteeResource($committee), 'Committee retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve committee data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve committee data, committee not found.');
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
            $committee = Committee::findOrFail($id);
            Log::info('Edit committee data for committee id: '.$id);
            return $this->sendResponse(new CommitteeResource($committee), 'Committee retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit committee data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit committee data, committee not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCommitteeRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $committee = Committee::findOrFail($id);
            $input['added_by'] = Auth::guard('api')->user()->id;
            if ($committee) {
                $update = $committee->fill($input)->save();
                if ($update) {
                    $members = $input['user_id'];
                    if (count($members)) {
                        $committee->members()->sync($members);
                    }
                    if ($request->hasFile('committee_photos')) {
                        //Delete old images to upload new
                        if ($committee->committeePhotos()) {
                            foreach ($committee->committeePhotos as $file) {
                                if (file_exists(storage_path('app/'.$file->file_path))) { 
                                    unlink(storage_path('app/'.$file->file_path));
                                }
                            }
                            $committee->committeePhotos()->delete();
                        }
                        //Add new images
                        $folder = 'committee_photos';
                        $input = $request->committee_photos;
                        $files = $request->file('committee_photos');
                        $this->fileUpload($folder, $input, $files, $committee);
                    }
                    Log::info('Committee updated successfully for committee id: '.$id);
                    return $this->sendResponse([], 'Committee updated successfully.');
                } else {
                    return $this->sendError('Failed to update committee.');     
                }
            } else{
                return $this->sendError('Committee not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update committee due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update committee.');
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
            $committee = Committee::findOrFail($id);
            if ($committee) {
                $accNeighbours = $committee->members()->detach();
                //Delete old images to upload new
                if ($committee->committeePhotos()) {
                    foreach ($committee->committeePhotos as $file) {
                        if (file_exists(storage_path('app/'.$file->file_path))) { 
                            unlink(storage_path('app/'.$file->file_path));
                        }
                    }
                    $committee->committeePhotos()->delete();
                }
                $committee->delete();
                Log::info('Committee deleted successfully for committee id: '.$id);
                return $this->sendResponse([], 'Committee deleted successfully.');
            } else {
                return $this->sendError('Committee not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete committee due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete committee.');
        }
    }
}
