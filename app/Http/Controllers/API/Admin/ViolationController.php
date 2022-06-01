<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\DocumentCategory;
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

            $userViolations = Violation::with('user', 'violationType')->whereHas('user', function ($query) use($request) {
                $query->where('first_name', 'LIKE', '%'.$request->get('name'). '%')
                ->where('last_name', 'LIKE', '%'.$request->get('name'). '%')
                ->where('mobile_no', 'LIKE', '%'.$request->get('phone'). '%')
                ->where('email', 'LIKE', '%'.$request->get('email'). '%')
                ->where('address', 'LIKE', '%'.$request->get('address'). '%');
            })
            ->when($request->has('in_active_user'), function ($query) use ($request) {
                $query->where('users.status', 0);
            })
            ->when($request->has('type'), function ($query) use ($request) {
                $query->where('violation_type_id', $request->type);
            })
            ->orderBy('violation_date', 'asc')->get();

            if (count($violationTypes)) {
                if (count($userViolations)) {
                    Log::info('Violations data displayed successfully.');
                    return $this->sendResponse(['violationTypes' => $violationTypes, 'userViolations' => $userViolations], 'Violations data retrieved successfully.');
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
        try {
            $docCategories = DocumentCategory::orderBy('title', 'asc')->get();
            $violationTypes = ViolationType::orderBy('type', 'ASC')->get();
            $authUser = Auth::guard('api')->user();

            if (count($docCategories) && count($violationTypes)) {
                Log::info('Document categories and violation types displayed successfully.');
                return $this->sendResponse(['docCategories' => $docCategories, 'violationTypes' => $violationTypes, 'authUser' => $authUser], 'Document categories and violation types displayed successfully.');
            } else {
                return $this->sendError('No data found for document categories and violation types.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve document categories and violation types due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve document categories and violation types.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreViolationRequest $request)
    {
        try {
            $input = $request->all();
            $input['approved_by'] = Auth::guard('api')->user()->id;
            $violation = Violation::create($input);
            if ($violation) {
                if ($request->hasFile('documents')) {
                    $folder = 'violation_documents';
                    $input = $request->documents;
                    $files = $request->file('documents');
                    $this->fileUpload($folder, $input, $files, $violation);
                }
                Log::info('Violation added successfully.');
                return $this->sendResponse($violation, 'Violation added successfully.');
            } else {
                return $this->sendError('Failed to add violation');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add violation due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add violation.');
        }
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
            $violation = Violation::find($id);
            if ($violation) {
                Log::info('Showing violation data for violation id: '.$id);
                return $this->sendResponse(new ViolationResource($violation), 'Violation retrieved successfully.');
            } else {
                return $this->sendError('Violation data not found.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve violation data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve violation data, violation not found.');
        }
    }

    /**
     * Update the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postResponse(Request $request, $id)
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
     * Mark notification as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markNotification(Request $request)
    {
        try {
            Auth::guard('api')->user()
                ->unreadNotifications
                ->when($request->input('id'), function ($query) use ($request) {
                    return $query->where('id', $request->input('id'));
                })
                ->markAsRead();
                Log::info('Notification marked as read.');
                return $this->sendResponse([], 'Notification marked as read.');

        } catch (Exception $e) {
            Log::error('Failed to update notification mark as read due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update notification mark as read.');
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
            $violation = Violation::find($id);
            if ($violation) {
                Log::info('Edit violation data for violation id: '.$id);
                return $this->sendResponse(new ViolationResource($violation), 'Violation retrieved successfully.');
            } else {
                return $this->sendError('Violation data not found.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to edit violation data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit violation data, violation not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreViolationRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $violation = Violation::find($id);
            if ($violation) {
                $update = $violation->fill($input)->save();
                if ($update) {
                    if ($request->hasFile('documents')) {
                        // Delete old documents to upload new
                        if ($violation->violationDocuments()) {
                            foreach ($violation->violationDocuments as $file) {
                                if (file_exists(storage_path('app/'.$file->file_path))) { 
                                    unlink(storage_path('app/'.$file->file_path));
                                }
                            }
                            $violation->violationDocuments()->delete();
                        }
                        // Add new document
                        $folder = 'violation_documents';
                        $input = $request->documents;
                        $files = $request->file('documents');
                        $this->fileUpload($folder, $input, $files, $violation);
                    }
                    Log::info('Violation updated successfully for violation id: '.$id);
                    return $this->sendResponse(new ViolationResource($violation), 'Violation updated successfully.');
                } else {
                    return $this->sendError('Failed to update violation.');      
                }
            } else {
                return $this->sendError('Violation not found to update');
            }
        } catch (Exception $e) {
            Log::error('Failed to update violation due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update violation.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        try {
            $violation = Violation::where('status', $request->get('status'))->get();
            if (count($violation)) {
                Log::info('Showing violations for status: '.$request->get('status'));
                return $this->sendResponse($violation, 'Violations retrieved successfully.');
            } else {
                return $this->sendError('Violations data not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve violations data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve violations data, violations not found.');
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
            $violation = Violation::find($id);
            if ($violation) {
                // Delete old documents to upload new
                if ($violation->violationDocuments()) {
                    foreach ($violation->violationDocuments as $file) {
                        if (file_exists(storage_path('app/'.$file->file_path))) { 
                            unlink(storage_path('app/'.$file->file_path));
                        }
                    }
                    $violation->violationDocuments()->delete();
                }
                if ($violation->delete()) {
                    Log::info('Violation deleted successfully for pet id: '.$id);
                    return $this->sendResponse([], 'Violation deleted successfully.');
                } else {
                    return $this->sendError('Violation can not be deleted.');
                }
            } else {
                return $this->sendError('Violation not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete violation due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete violation.');
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
            $violation = Violation::whereIn('id',explode(",",$ids))->get();

            if ($violation) {
                foreach ($violation as $selectedViolations) {
                    // Delete old documents to upload new
                    if ($selectedViolations->violationDocuments()) {
                        foreach ($selectedViolations->violationDocuments as $file) {
                            if (file_exists(storage_path('app/'.$file->file_path))) { 
                                unlink(storage_path('app/'.$file->file_path));
                            }
                        }
                        $selectedViolations->violationDocuments()->delete();
                    }
                    $selectedViolations->delete();
                }
                Log::info('Selected violation deleted successfully');
                return $this->sendResponse([], 'Selected violation deleted successfully.');
            } else {
                return $this->sendError('Violation not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete violations due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete violations.');
        }
    }

}
