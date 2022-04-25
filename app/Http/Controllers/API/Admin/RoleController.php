<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Role;
use App\Http\Resources\Role as RoleResource;
use App\Http\Requests\StoreRoleRequest;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $roles = Role::all();
            if (count($roles)) {
                Log::info('Roles data displayed successfully.');
                return $this->sendResponse(RoleResource::collection($roles), 'Roles data retrieved successfully.');
            } else {
                return $this->sendError('No data found for roles.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve roles data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve roles data.');
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
    public function store(StoreRoleRequest $request)
    {
        try {
            $input = $request->all();
            $input['approved_by'] = Auth::guard('api')->user()->id;
            $role = Role::create($input);
            if ($role) {
                Log::info('Role added successfully.');
                return $this->sendResponse(new RoleResource($role), 'Role added successfully.');
            } else {
                return $this->sendError('Failed to add role');     
            }
        } catch (Exception $e) {
            Log::error('Failed to add role due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add role.');
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
            $role = Role::findOrFail($id);
            Log::info('Showing role data for role id: '.$id);
            return $this->sendResponse(new RoleResource($role), 'Role retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve role data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve role data, role not found.');
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
            $role = Role::findOrFail($id);
            Log::info('Edit role data for role id: '.$id);
            return $this->sendResponse(new RoleResource($role), 'Role retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit role data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to edit role data, role not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreroleRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $role = Role::findOrFail($id);
            if ($role) {
                $updated = $role->fill($input)->save();
                if ($updated) {
                    Log::info('Role updated successfully for role id: '.$id);
                    return $this->sendResponse(new RoleResource($role), 'Role updated successfully.');
                } else {
                    return $this->sendError('Failed to update role.');      
                }
            } else {
                return $this->sendError('Role not found.');   
            }
        } catch (Exception $e) {
            Log::error('Failed to update role data due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to update role.');
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
            $role = Role::findOrFail($id);
            if ($role) {
                if ($role->delete()) {
                    Log::info('Role deleted successfully for role id: '.$id);
                    return $this->sendResponse([], 'Role deleted successfully.');
                } else {
                    return $this->sendError('Role can not be deleted.');
                }
            } else {
                return $this->sendError('Role not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete role due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete role.');
        }
    }
}
