<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Permission;
use App\Models\PermissionHeading;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Resources\Permission as PermissionResource;
use App\Http\Resources\PermissionHeading as PermissionHeadingResource;

class PermissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $permissions = Permission::all();
            if (count($permissions)) {
                Log::info('Permissions data displayed successfully.');
                return $this->sendResponse(PermissionResource::collection($permissions), 'Permissions data retrieved successfully.');
            } else {
                return $this->sendError('No data found for permissions.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve permissions due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Failed to retrieve permissions.');
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
            $headings = PermissionHeading::pluck('heading','id');
            if (count($headings)) {
                Log::info('Permission-headings data displayed successfully.');
                return $this->sendResponse($headings, 'Permission-headings data retrieved successfully.');
            } else {
                return $this->sendError('No data found for permission-headings.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve permission-headings due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Failed to retrieve permission-headings.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
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
            $permission = Permission::create($input);
            if ($permission) {
                Log::info('Permission added successfully.');
                return $this->sendResponse(new PermissionResource($permission), 'Permission added successfully.');
            } else {
                return $this->sendError('Failed to add permission.');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add permission due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add permission');
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
            $permission = Permission::findOrFail($id);
            Log::info('Showing permission for permission id: '.$id);
            return $this->sendResponse(new PermissionResource($permission), 'Permission retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve permission due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve permission data, permission not found.');
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
            $headings = PermissionHeading::pluck('heading', 'id');
            $permission = Permission::find($id);
            Log::info('Edit permissions for heading id: '.$id);
            return $this->sendResponse(['permissionHeadings' => $headings, 'permissions' => new PermissionResource($permission)], 'Permissions data retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit permissions due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit permissions data, permissions not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePermissionRequest $request, $id)
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
            $headings = Permission::findOrFail($id);
            if ($headings) {
                $update = $headings->fill($input)->save();
                if ($update) {
                    Log::info('Permission updated successfully for permission id: '.$id);
                    return $this->sendResponse(new PermissionResource($headings), 'Permission updated successfully.');
                } else {
                    return $this->sendError('Failed to update permission.');     
                }
            } else {
                return $this->sendError('Permission not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to update permission due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update permission.');
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
            $message = 'Permission does not found! Please try again.'; 
            $permission = Permission::findOrFail($id);
            if ($permission) {
                $message = 'Cannot delete permission, permission is assigned to the role!';
                if (!$permission->roles()->count()) {
                    $permission->delete();
                    Log::info('Permission deleted successfully for permission id: '.$id);
                    return $this->sendResponse([], 'Permission deleted successfully.');
				}
                return $this->sendError($message);
            }
        } catch (Exception $e) {
            Log::error($message.'-'. $e->getMessage());
            return $this->sendError($message);
        }
    }
}
