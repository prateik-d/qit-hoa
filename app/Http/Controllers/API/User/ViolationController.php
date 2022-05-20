<?php

namespace App\Http\Controllers\API\User;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Violation;
use App\Models\ViolationType;
use App\Models\ViolationDocument;
use App\Http\Resources\Violation as ViolationResource;
use App\Http\Requests\StoreViolationRequest;
use App\Models\User;
use Notification;
use App\Notifications\ViolationCloseRequestNotification;

class ViolationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $violationTypes = ViolationType::orderBy('type', 'ASC')->get();

            $violations = Violation::with('violationType')
                        ->where('status', 'open')
                        ->where('description', 'LIKE', '%'.$request->get('title'). '%')
                        ->where('violation_date', 'LIKE', '%'.$request->get('date'). '%')
                        ->where('violation_type_id', 'LIKE', '%'.$request->get('type'). '%')
                        ->where('status', 'LIKE', '%'.$request->get('status'). '%')->get();
                
            if (count($violationTypes)) {
                return $this->sendResponse($violationTypes, 'Violation-types data retrieved successfully.');
                if (count($violations)) {
                    Log::info('Violations data displayed successfully.');
                    return $this->sendResponse([$violationTypes, 'Violation-types data retrieved successfully.', ViolationResource::collection($violations), 'Violations data retrieved successfully.']);
                } else {
                    return $this->sendError('No data found for violations');
                }
            } else {
                return $this->sendError('No data found for violation types');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve violations data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve violations data.');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * File upload for violation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $input, $files, $violation)
    {
        try {
            $allowedfileExtension = ['pdf','jpg','jpeg','png','xlsx','bmp'];
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                if ($check) {
                    foreach((array)$input as $mediaFiles) {
                        $name = $mediaFiles->getClientOriginalName();
                        $filename = $violation->id.'-'.$name;
                        $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                        //store document file into directory and db
                        $violationDocuments = new violationDocument();
                        $violationDocuments->violation_id = $violation->id;
                        $violationDocuments->file_path = $path;
                        $violationDocuments->save();
                    }
                } else {
                    return $this->sendError('invalid_file_format'); 
                }
                Log::info('File uploaded successfully.');
                return response()->json(['file uploaded'], 200);
            }
        } catch (Exception $e) {
            Log::error('Failed to upload event images due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload event images.');
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
            $violation = Violation::findOrFail($id);
            Log::info('Showing violation data for violation id: '.$id);
            return $this->sendResponse(new ViolationResource($violation), 'Violation retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve violation data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve violation data, violation not found.');
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
            $violation = Auth::guard('api')->user()->violations->find($id);
            Log::info('Edit violation data for violation id: '.$id);
            return $this->sendResponse(new ViolationResource($violation), 'Violation retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit violation data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit violation data, violation not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     * Post reply with evidence
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate document
        $validator = $this->validate(
            $request, 
        [
            'user_reply' => 'required',
            'documents.*' => 'mimes:jpg,jpeg,bmp,png,pdf,xlsx',
            'documents' => 'required|max:5',
        ],
        [
            "documents.max" => "file can't be more than 5."
        ]);
        
        try {
            $input = $request->except(['_method']);
            $admins = User::whereHas('role', function ($query) {
                $query->where('id', 1);
            })->get();

            $violation = Auth::guard('api')->user()->violations->find($id);
            if ($violation) {
                if ($violation->user_reply == null) {
                    $saveReply = [
                        'user_reply' => $request->user_reply
                    ];
                    $update = $violation->update($saveReply);
                    if ($update) {
                        if ($request->hasFile('documents')) {
                            
                            // Add new document
                            $folder = 'violation_evidence_documents';
                            $input = $request->documents;
                            $files = $request->file('documents');
                            $this->fileUpload($folder, $input, $files, $violation);
                        }
                        Notification::send($admins, new ViolationCloseRequestNotification($violation));
                        Log::info('Reply posted successfully for violation id: '.$id);
                        return $this->sendResponse(new ViolationResource($violation), 'Reply posted updated successfully.');
                    } else {
                        return $this->sendError('Failed to post reply.');      
                    }
                } else {
                    return $this->sendError('You are already posted reply with evidence for violation close request.');
                }
            } else {
                return $this->sendError('Violation not found to post reply');
            }
        } catch (Exception $e) {
            Log::error('Failed to post reply due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to post reply.');
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
        //
    }
}
