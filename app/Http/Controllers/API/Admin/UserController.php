<?php

namespace App\Http\Controllers\API\Admin;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $users = User::where('first_name', 'LIKE', '%'.$request->get('name'). '%')
                ->where('last_name', 'LIKE', '%'.$request->get('name'). '%')
                ->where('mobile_no', 'LIKE' , '%'.$request->get('phone').'%')
                ->where('email', 'LIKE' , '%'.$request->get('email').'%')
                ->where('address', 'LIKE' , '%'.$request->get('address').'%')->get();

            if (count($users)) {
                Log::info('Users data displayed successfully');
                return $this->sendResponse(new UserResource($users), 'Users data retrieved successfully.');
            } else {
                return $this->sendError('No data found for users');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve users due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve users');
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
    public function store(StoreUserRequest $request)
    {
        try {
            $input = $request->all();
            if ($request->hasFile('profile_pic')) {
                $file = $request->file('profile_pic');
                $name = $file->getClientOriginalName();
                $filename = $input['first_name'].$input['last_name'].'-'.$name;
                $path = $file->storeAs('public/Members_profile_pic', $filename);
                $input['profile_pic'] = $path;
            }
            $user = User::create($input);
            if($user) {
                Log::info('User added successfully');
                return $this->sendResponse(new UserResource($user), 'User created successfully.');
            } else {
                return $this->sendError('Failed to add user');      
            }
        } catch (Exception $e) {
            Log::error('Failed to add user due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to add user');
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
            $user = User::findOrFail($id);
            Log::info('Showing user for user id: '.$id);
            return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve user due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve user data, user not found');
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
            $user = User::findOrFail($id);
            Log::info('Edit user data for user id: '.$id);
            return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to edit user due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve user data, user not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            $user = User::findOrFail($id);
            if ($user) {
                if ($request->hasFile('profile_pic')) {
                    // To delete old images
                    if ($user->profile_pic != null) {
                        if (file_exists(storage_path('app/'.$user->profile_pic))) { 
                            unlink(storage_path('app/'.$user->profile_pic));
                        }
                    }
                    // add new images
                    $file = $request->file('profile_pic');
                    $name = $file->getClientOriginalName();
                    $filename = $input['first_name'].$input['last_name'].'-'.$name;
                    $path = $file->storeAs('public/Members_profile_pic', $filename);
                    $input['profile_pic'] = $path;
                }
                $update = $user->fill($input)->save();
                if ($update) {
                    Log::info('User updated for user id: '.$id);
                    return $this->sendResponse([], 'User updated successfully.');
                } else {
                    return $this->sendError('Failed to update user.');      
                }
            } else {
                return $this->sendError('user not found.');      
            }
        } catch (Exception $e) {
            Log::error('Failed to update user due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Opeartion failed to update user');
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
            $user = User::findOrFail($id);
            if ($user) {
                if ($user->profile_pic != null) {
                    if (file_exists(storage_path('app/'.$user->profile_pic))) { 
                        unlink(storage_path('app/'.$user->profile_pic));
                    }
                }
                $user->delete();
                Log::info('User deleted successfully for user id: '.$id);
                return $this->sendResponse([], 'User deleted successfully.');
            } else {
                return $this->sendError('User not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete user due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete user');
        }
    }
}
