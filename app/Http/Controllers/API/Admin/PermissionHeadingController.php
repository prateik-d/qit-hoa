<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\PermissionHeading;
use App\Http\Requests\StorePermissionHeadingRequest;
use App\Http\Resources\PermissionHeading as PermissionHeadingResource;

class PermissionHeadingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $permissionHeadings = PermissionHeading::all();
            if (count($permissionHeadings)) {
                Log::info('Permission-headings data displayed successfully.');
                return $this->sendResponse(PermissionHeadingResource::collection($permissionHeadings), 'Permission-headings data retrieved successfully.');
            } else {
                return $this->sendError('No data found for permission-headings.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve permission-headings due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Failed to retrieve permission-headings.');
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
    public function store(StorePermissionHeadingRequest $request)
    {
        try {
            $input = $request->all();
            if ($request->status) {
                if ($input['status'] == 'on') {
                    $input['status'] = 1;
                } else {
                    $input['status'] = 0;
                }
            }
            $permissionHeading = PermissionHeading::create($input);
            if ($permissionHeading) {
                Log::info('Permission-heading added successfully.');
                return $this->sendResponse(new PermissionHeadingResource($permissionHeading), 'Permission-heading added successfully.');
            } else {
                return $this->sendError('Failed to add permission-heading.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add permission-heading due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add permission-heading');
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
            $permissionHeading = PermissionHeading::findOrFail($id);
            Log::info('Showing permission-heading for heading id: '.$id);
            return $this->sendResponse(new PermissionHeadingResource($permissionHeading), 'Permission-heading retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve permission-heading due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve permission-heading data, permission-heading not found.');
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
            $permissionHeading = PermissionHeading::findOrFail($id);
            Log::info('Edit permission-heading for heading id: '.$id);
            return $this->sendResponse(new PermissionHeadingResource($permissionHeading), 'Permission-heading retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit permission-heading due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit permission-heading data, permission-heading not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePermissionHeadingRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            if ($request->status) {
                if ($input['status'] == 'on') {
                    $input['status'] = 1;
                } else {
                    $input['status'] = 0;
                }
            }
            $permissionHeading = PermissionHeading::findOrFail($id);
            if ($permissionHeading) {
                $update = $permissionHeading->fill($input)->save();
                if ($update) {
                    Log::info('Permission-heading updated successfully for permission-heading id: '.$id);
                    return $this->sendResponse(new PermissionHeadingResource($permissionHeading), 'Permission-heading updated successfully.');
                } else {
                    return $this->sendError('Failed to update permission-heading.');     
                }
            } else {
                return $this->sendError('Permission-heading not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update permission-heading due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update permission-heading.');
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
            $message = 'Permission-heading does not found! Please try again.'; 
            $permissionHeading = PermissionHeading::findOrFail($id);
            if ($permissionHeading) {
                $message = 'Cannot delete permission-heading, permission-heading is assigned to the lost-found-items!';
                if (!$permissionHeading->permissions()->count()) {
                    $permissionHeading->delete();
                    Log::info('Permission-heading deleted successfully for permission-heading id: '.$id);
                    return $this->sendResponse([], 'Permission-heading deleted successfully.');
				}
                return $this->sendError($message);
            }
        } catch (Exception $e) {
            Log::error($message.'-'. $e->getMessage());
            return $this->sendError($message);
        }
    }
}
