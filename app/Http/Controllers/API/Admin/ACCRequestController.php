<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\AccRequest;
use App\Models\AccDocument;
use App\Models\User;
use App\Http\Resources\ACCRequest as ACCRequestResource;
use App\Http\Requests\StoreACCRequest;
use App\Exports\AccRequestExport;
use Maatwebsite\Excel\Facades\Excel;

class ACCRequestController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
        //     if ($request->in_active_user) {
        //         if ($request->get('in_active_user') == 'on') {
        //             $user = User::with('usersAccRequests')->where('status', 0);
        //         }
        //     } else {
        //         $user = User::with('usersAccRequests');
        //     }
        //     $accRequest = $user->whereHas('usersAccRequests', function ($query) use($request) {
        //         $query->where('first_name', 'LIKE', '%'.$request->get('name'). '%')
        //         ->where('last_name', 'LIKE', '%'.$request->get('name'). '%')
        //         ->where('mobile_no', 'LIKE', '%'.$request->get('phone'). '%')
        //         ->where('email', 'LIKE', '%'.$request->get('email'). '%')
        //         ->where('address', 'LIKE', '%'.$request->get('address'). '%');
        //    })->get();

           $accRequest = AccRequest::with('createdByUser')->whereHas('createdByUser', function ($query) use($request) {
            $query->where('first_name', 'LIKE', '%'.$request->get('name'). '%')
            ->where('last_name', 'LIKE', '%'.$request->get('name'). '%')
            ->where('mobile_no', 'LIKE', '%'.$request->get('phone'). '%')
            ->where('email', 'LIKE', '%'.$request->get('email'). '%')
            ->where('address', 'LIKE', '%'.$request->get('address'). '%');
            })
            ->when($request->has('in_active_user'), function ($query) use ($request) {
                $query->where('users.status', 0);
            })
            ->orderBy('title', 'asc')->get();

            if (count($accRequest)) {
                Log::info('ACC-request data displayed successfully.');
                return $this->sendResponse($accRequest, 'ACC-request data retrieved successfully.');
            } else {
                return $this->sendError('No data found for acc-request');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve acc-request data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve acc-request data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Autoill loggedin users details
        try {
            $user = Auth::guard('api')->user();

            if (count($user)) {
                Log::info('User data displayed successfully.');
                return $this->sendResponse($user, 'User data retrieved successfully.');
            } else {
                return $this->sendError('No data found for user.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve user due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve user.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreACCRequest $request)
    {
        try {
            $input = $request->all();
            if (Auth::guard('api')->user()->id == $input['user_id']) {
                $accRequest = AccRequest::create($input);
                $neighbours = $input['neighbour_id'];
                if (count($neighbours)) {
                    $accRequest->users()->attach($neighbours);
                }
                if ($accRequest) {
                     if ($request->hasFile('city_permit_document')) {
                        $folder = 'city_permit_documents';
                        $input = $request->city_permit_document;
                        $files = $request->file('city_permit_document');
                        $this->fileUpload($folder, $input, $files, $accRequest);
                    }
                     if($request->hasFile('supporting_document')) {
                        $folder = 'supporting_documents';
                        $input = $request->supporting_document;
                        $files = $request->file('supporting_document');
                        $this->fileUpload($folder, $input, $files, $accRequest);
                    }
                    Log::info('ACC-request raised successfully.');
                    return $this->sendResponse(new ACCRequestResource($accRequest), 'ACC-request added successfully.');
                } else {
                    return $this->sendError('Failed to add acc-request');     
                }
            } else {
                return $this->sendError('Failed to add acc-request, user is unauthenticated, Please provide authenticated user id'); 
            }
        } catch (Exception $e) {
            Log::error('Failed to add acc-request due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add acc-request.');
        }
    }

    /**
     * File upload for ACC Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $input, $files, $accRequest)
    {
        try {
            $allowedfileExtension = ['pdf','jpg','jpeg','png','xlsx','bmp'];
            foreach ($files as $file) {      
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                if($check) {
                    foreach((array)$input as $mediaFiles) {
                        $name = $mediaFiles->getClientOriginalName();
                        $filename = $accRequest->id.'-'.$name;
                        $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                        $ext  =  $mediaFiles->getClientOriginalExtension();
                        //store image file into directory and db
                        $accDocument = [
                            'acc_id'    => $accRequest->id,
                            'file_type' => $folder,
                            'file_path' => $path,
                        ];
                        AccDocument::create($accDocument);
                    }
                } else {
                    return $this->sendError('invalid_file_format'); 
                }
                Log::info('File uploaded successfully.');
                return response()->json(['file uploaded'], 200);
            }
        } catch (Exception $e) {
            Log::error('Failed to upload acc-request documents due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload acc-request documents.');
        }
    }
    
    /**
     * Display a listing of the received request for approval resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function receivedApprovalRequest(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();
            
            $result = AccRequest::whereHas('users', function ($query) use($request, $user) {
                $query->where('neighbour_id', $user->id)->where('title', 'LIKE', '%'.$request->get('title'). '%')
                ->where('acc_requests.created_at', 'LIKE' , '%'.$request->get('date').'%')
                ->where('status', 'LIKE' , '%'.$request->get('status').'%');
            })->get();

            if (count($result)) {
                Log::info('Received acc-request retrieved successfully.');
                return $this->sendResponse(ACCRequestResource::collection($result), 'Received acc-request retrieved successfully.');
            } else {
                return $this->sendError('Failed to retrieve received acc-request.');  
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve received acc-request data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve received acc-request data.');
        }
    }

    /**
     * Display a listing of the my acc request resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myAccRequest(Request $request)
    {
        try {
            $result = AccRequest::whereHas('users', function ($query) use($request) {
                $user = Auth::guard('api')->user();
                $query->where('user_id', $user->id)->where('title', 'LIKE', '%'.$request->get('title'). '%')
                ->where('acc_requests.created_at', 'LIKE' , '%'.$request->get('date').'%')
                ->where('status', 'LIKE' , '%'.$request->get('status').'%');
            })->get();

            if (count($result)) {
                Log::info('Acc-request retrieved successfully.');
                return $this->sendResponse(ACCRequestResource::collection($result), 'Acc-request retrieved successfully.');
            } else {
                return $this->sendError('Failed to retrieve acc-request.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve acc-request data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve acc-request data.');
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
            $accRequest = ACCRequest::findOrFail($id);
            Log::info('Showing acc-request data for acc-request id: '.$id);
            return $this->sendResponse(new ACCRequestResource($accRequest), 'ACC-request retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve acc-request data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve acc-request data, acc-request not found.');
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
            $accRequest = ACCRequest::findOrFail($id);
            Log::info('Edit acc-request data for acc-request id: '.$id);
            return $this->sendResponse(new ACCRequestResource($accRequest), 'ACC-request retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit acc-request data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit acc-request data, acc-request not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreACCRequest $request, $id)
    {
        try {
            $input = $request->all();
            $accRequest = ACCRequest::find($id);
            if ($accRequest) {
                if (Auth::guard('api')->user()->id == $input['user_id']) {
                    $update = $accRequest->fill($input)->save();
                    if ($update) {
                        $neighbours = $input['neighbour_id'];
                        if (count($neighbours)) {
                            $accRequest->users()->sync($neighbours);
                        }

                        // Add City permit document
                        if ($request->hasFile('city_permit_document')) {
                            // Delete old documents to upload new
                            if ($accRequest->accDocuments()) {
                                foreach ($accRequest->accDocuments as $file) {
                                    // To delete old city permit document
                                    if ($file->file_type == 'city_permit_documents') {
                                        if (file_exists(storage_path('app/'.$file->file_path))) { 
                                            unlink(storage_path('app/'.$file->file_path));
                                            $file->delete();
                                        }
                                    }
                                    // To delete old supporting document
                                    if ($file->file_type == 'supporting_documents') {
                                        if (file_exists(storage_path('app/'.$file->file_path))) { 
                                            unlink(storage_path('app/'.$file->file_path));
                                            $file->delete();
                                        }
                                    }
                                }
                            }
                            // To add new documents
                            $folder = 'city_permit_documents';
                            $input = $request->city_permit_document;
                            $files = $request->file('city_permit_document');
                            $this->fileUpload($folder, $input, $files, $accRequest);
                        }

                        // Add supporting document
                        if ($request->hasFile('supporting_document')) {
                            // Delete old documents to upload new
                            if ($accRequest->accDocuments()) {
                                foreach ($accRequest->accDocuments as $file) {
                                    // To delete old supporting document
                                    if ($file->file_type == 'supporting_documents') {
                                        if (file_exists(storage_path('app/'.$file->file_path))) { 
                                            unlink(storage_path('app/'.$file->file_path));
                                            $file->delete();
                                        }
                                    }
                                    // To delete old city permit document
                                    if ($file->file_type == 'city_permit_documents') {
                                        if (file_exists(storage_path('app/'.$file->file_path))) { 
                                            unlink(storage_path('app/'.$file->file_path));
                                            $file->delete();
                                        }
                                    }
                                }
                            }
                            // To add new documents
                            $folder = 'supporting_documents';
                            $input = $request->supporting_document;
                            $files = $request->file('supporting_document');
                            $this->fileUpload($folder, $input, $files, $accRequest);
                        }
                        Log::info('ACC-request updated successfully for acc-request id: '.$id);
                        return $this->sendResponse([], 'ACC-request updated successfully.');
                    } else {
                        return $this->sendError('Failed to update acc-request');     
                    }
                } else {
                    return $this->sendError('Failed to update acc-request, user is unauthenticated, Please provide authenticated used id'); 
                }
            } else {
                return $this->sendError('ACC-request not found');     
            }
        } catch (Exception $e) {
            Log::error('Failed to update acc-request data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update acc-request.');
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
            $accRequest = ACCRequest::where('status', $request->get('status'))->get();
            if (count($accRequest)) {
                Log::info('Showing acc-requests for status: '.$request->get('status'));
                return $this->sendResponse($violation, 'acc-requests retrieved successfully.');
            } else {
                return $this->sendError('ACC-requests data not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve acc-requests data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve acc-requests data, acc-requests not found.');
        }
    }

    /**
     * Approve/Reject the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function myApproval(Request $request, $id)
    {
        try {
            $inputs = $request->all();
            $user = Auth::guard('api')->user();
            $approvalRequest = $user->accRequests->where('id', $id)->first();

            if ($approvalRequest) {
                if ($inputs['approval_status'] == 'approve') {
                    $inputs['approval_status'] = 'approved';
                } else if ($inputs['approval_status'] == 'reject') {
                    $inputs['approval_status'] = 'rejected';
                }
                $result = $approvalRequest->pivot->update($inputs);
                Log::info('ACC-request updated successfully for acc-request id: '.$id);
                return $this->sendResponse($result, 'Acc-request'.' '.$inputs['approval_status'].' '.'successfully');
            } else {
                return response()->json(['Result' => 'Approval request does not found'], 404);
            }
        } catch (Exception $e) {
            Log::error('Failed to update acc-request data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update acc-request.');
        }
    }
    
    public function export()
    {
        return Excel::download(new AccRequestExport, 'acc-request.xlsx');
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
            $accRequest = ACCRequest::findOrFail($id);
            if ($accRequest) {
                $accNeighbours = $accRequest->users()->detach();
                if ($accRequest->accDocuments()) {
                    foreach ($accRequest->accDocuments as $file) {
                        if (file_exists(storage_path('app/'.$file->file_path))) { 
                            unlink(storage_path('app/'.$file->file_path));
                        }
                    }
                    $accRequest->accDocuments()->delete();
                }
                $accRequest->delete();
                Log::info('ACC-request deleted successfully for acc-request id: '.$id);
                return $this->sendResponse([], 'ACC-request deleted successfully.');
            } else {
                return $this->sendError('ACC-request not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete acc-request due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete acc-request.');
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
            $accRequest = ACCRequest::whereIn('id',explode(",",$ids))->get();
            if ($accRequest) {
                foreach ($accRequest as $acc) {
                    $accNeighbours = $acc->users()->detach();
                    if ($acc->accDocuments()) {
                        foreach ($acc->accDocuments as $file) {
                            if (file_exists(storage_path('app/'.$file->file_path))) { 
                                unlink(storage_path('app/'.$file->file_path));
                            }
                        }
                        $acc->accDocuments()->delete();
                    }
                    $acc->delete();
                }
                Log::info('Selected acc-requests deleted successfully');
                return $this->sendResponse([], 'Selected acc-requests deleted successfully.');
            } else {
                return $this->sendError('ACC-request not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete acc-requests due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete acc-requests.');
        }
    }
}