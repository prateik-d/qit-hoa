<?php

namespace App\Http\Controllers\API\Admin;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Notification;
use App\Notifications\UserEmailNotification;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\State;
use App\Models\User;
use App\Models\UserDocument;
use App\Models\DocumentCategory;
use App\Models\Role;
use App\Models\Pet;
use App\Models\City;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\StoreUserRequest;

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
            $input = $request->all();

            $roles = Role::orderBy('role_type', 'asc')->get();
            $users = User::with('role', 'city', 'state', 'pets')
                    ->where(DB::raw('CONCAT(first_name, " ",last_name)'), 'LIKE' , '%'.$request->get('name').'%')
                    ->where('mobile_no', 'LIKE' , '%'.$request->get('phone').'%')
                    ->where('email', 'LIKE' , '%'.$request->get('email').'%')
                    ->where('address', 'LIKE' , '%'.$request->get('address').'%')
                    ->where('role_id', 'LIKE' , '%'.$request->get('type').'%')
                    ->when($request->has('pet_owner'), function ($query) use ($request) {
                        //$query->has('pets');
                    })
                    ->when($request->has('inactive_user'), function ($query) use ($request) {
                        $query->where('status', 'LIKE' , '%'.$request->inactive_user.'%');
                    })->get();

                    
            // if ($request->pet_owner) {
            //     if ($input['pet_owner'] == 'on') {
            //         $pets = Pet::with('owner')->get();
            //         foreach ($pets as $petOwners) 
            //         {
            //             $result = $petOwners->whereHas('owner', function($query) use($request) {
            //                 $query->where('first_name', 'LIKE' , '%'.$request->get('name').'%')
            //                 ->orwhere('last_name', 'LIKE', '%'.$request->get('name'). '%')
            //                 ->where('mobile_no', 'LIKE' , '%'.$request->get('phone').'%')
            //                 ->where('email', 'LIKE' , '%'.$request->get('email').'%')
            //                 ->where('address', 'LIKE' , '%'.$request->get('address').'%')
            //                 ->where('role_id', 'LIKE' , '%'.$request->get('type').'%');
            //             })->groupBy('owner_id')->get();
            //         }
            //         $users = array();
            //         foreach ($result as $data) {
            //             $user = $data->owner;
            //             array_push($users,$user);
            //         }
            //     }
            // }

            //if (count($users)) {
                Log::info('Users data displayed successfully');
                return $this->sendResponse(['roles' => $roles, 'users' => $users], 'Users data retrieved successfully.');
            // } else {
            //     return $this->sendError([], 'No data found for users');
            // }
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
        try {
            $roles = Role::orderBy('role_type', 'ASC')->get();
            $states = State::orderBy('state', 'ASC')->get();
            $docCategories = DocumentCategory::orderBy('title','asc')->get();

            if (count($roles) && count($states)) {
                Log::info('Roles data displayed successfully.');
                return $this->sendResponse(['roles' => $roles, 'states' => $states, 'docCategories' =>  $docCategories], 'Roles data retrieved successfully.');
            } else {
                return $this->sendError('No data found for roles.');
            }
        } catch (Exception $e) {
            Log::error('Failed to retrieve roles due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve roles.');
        }
    }

    /**
     * get cities list based on state.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCityList(Request $request)
    {
        try {
            $cities = City::where('state_id', $request->dataId)->orderBy('city', 'ASC')->get();
            Log::info('Showing cities for state id: '.$request->dataId);
            return $this->sendResponse(['cities' => $cities], 'City data retrieved successfully.');
        } catch (Exception $e) {
            Log::error('Failed to retrieve cities due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to retrieve cities data, cities not found');
        }
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
            $random_password = Str::random(8);
            $input['password'] = Hash::make($random_password);

            $admin = User::where('id', 1)->first();

            if ($request->hasFile('profile_pic')) {
                $file = $request->file('profile_pic');
                $name = $file->getClientOriginalName();
                $filename = $input['first_name'].$input['last_name'].'-'.$name;
                $path = $file->storeAs('public/users_profile_pic', $filename);
                $input['profile_pic'] = $path;
            }
            $user = User::create($input);
            if ($user) {
                if ($request->hasFile('document')) {
                    $type = $input['document_type'];
                    $folder = 'user_documents';
                    $fileInput = $request->document;
                    $files = $request->file('document');
                    $this->fileUpload($folder, $fileInput, $type, $files, $user);
                }
                // Send email
                $userData = [
                    'name' => 'Customer Name : ' . ucfirst($user->full_name),
                    'from' => $admin->email,
                    'body' => 'User Credentials :',
                    'username' => 'Username : ' . $user->email,
                    'password' => 'Password : ' . $random_password,
                ];
                Notification::route('mail', $user->email)->notify(new UserEmailNotification($userData));
                // Generate success log
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
     * File upload for user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileUpload($folder, $fileInput, $type, $files, $user)
    {
        try {
            $allowedfileExtension = ['pdf','jpg','jpeg','png','xlsx','bmp'];
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                if($check) {
                    foreach((array)$fileInput as $mediaFiles) {
                        $name = $mediaFiles->getClientOriginalName();
                        $filename = $user->id.'-'.$name;
                        $path = $mediaFiles->storeAs('public/'.$folder, $filename);
                        $ext  =  $mediaFiles->getClientOriginalExtension();
                        //store documents file into directory and db
                        $userDocuments = new UserDocument();
                        $userDocuments->user_id = $user->id;
                        $userDocuments->file_type = $type;
                        $userDocuments->file_path = $path;
                        $userDocuments->save();
                    }
                } else {
                    return $this->sendError('invalid_file_format'); 
                }
                Log::info('File uploaded successfully.');
                return response()->json(['file uploaded'], 200);
            }
        } catch (Exception $e) {
            Log::error('Failed to upload user documents due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to upload user documents.');
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
            $user = User::with('role', 'city', 'state', 'pets')->find($id);
            Log::info('Showing user for user id: '.$id);
            return $this->sendResponse(['user' => $user], 'User retrieved successfully.');
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
            $roles = Role::orderBy('role_type', 'ASC')->get();
            $states = State::orderBy('state', 'ASC')->get();
            $docCategories = DocumentCategory::orderBy('title','asc')->get();
            $user = User::with('role', 'city', 'state', 'pets')->find($id);
            Log::info('Edit user data for user id: '.$id);
            return $this->sendResponse(['roles' => $roles, 'states' => $states, 'docCategories' =>  $docCategories, 'user' => $user], 'User retrieved successfully.');
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
    public function update(StoreUserRequest $request, $id)
    {
        try {
            $input = $request->except(['_method']);
            // if (isset($input['password']) && !empty($input['password'])) {
            //     $input['password'] = bcrypt($input['password']);
            // } else {
            //     $input = $request->except(['password']);
            // }
            $user = User::findOrFail($id);
            if ($user) {
                if ($request->hasFile('profile_pic')) {
                    // To delete old profile pic
                    if ($user->profile_pic != null) {
                        if (file_exists(storage_path('app/'.$user->profile_pic))) { 
                            unlink(storage_path('app/'.$user->profile_pic));
                        }
                    }
                    // add new profile pic
                    $file = $request->file('profile_pic');
                    $name = $file->getClientOriginalName();
                    $filename = $input['first_name'].$input['last_name'].'-'.$name;
                    $path = $file->storeAs('public/users_profile_pic', $filename);
                    $input['profile_pic'] = $path;
                }
                $update = $user->fill($input)->save();
                if ($update) {
                    if ($request->hasFile('document')) {
                        // Delete old documents to upload new
                        if ($user->userDocuments()) {
                            foreach ($user->userDocuments as $file) {
                                if (file_exists(storage_path('app/'.$file->file_path))) { 
                                    unlink(storage_path('app/'.$file->file_path));
                                }
                            }
                            $user->userDocuments()->delete();
                        }
                        // Add new documents
                        $folder = 'user_documents';
                        $fileInput = $request->document;
                        $files = $request->file('document');
                        $this->fileUpload($folder, $fileInput, $input, $files, $user);
                    }
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
            $user = User::find($id);
            if ($user) {
                $message = 'Cannot delete user, user is assigned to the pet!';
                if ($user->pets->count()) {
                    $user->pets->delete();
                }
                // if ($user->events->count()) {
                //     $user->events->delete();
                // }
                if ($user->profile_pic != null) {
                    if (file_exists(storage_path('app/'.$user->profile_pic))) { 
                        unlink(storage_path('app/'.$user->profile_pic));
                    }
                }
                $user->delete();
                Log::info('User deleted successfully for user id: '.$id);
                return $this->sendResponse([], 'User deleted successfully.');
            } else {
                return $this->sendError([], 'User not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete user due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete user');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUserDetails(Request $request)
    {
        try {
            $users = User::with('role')
            ->where(DB::raw('CONCAT(first_name, " ",last_name)'), $request->data)
            ->orWhere('mobile_no', $request->data)
            ->orWhere('email', $request->data)
            ->orWhere('reg_code', $request->data)
            ->orWhere('address', $request->data)
            ->get();

            if (count($users)) {
                Log::info('users data displayed successfully.');
                return $this->sendResponse($users, 'users data retrieved successfully.');
            } else {
                return $this->sendError([], 'No data found for user');
            }
        } catch (Exception $e) {
            Log::error('Failed to get user details due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to get user details');
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
            $users = User::whereIn('id',explode(",",$ids))->get();
            if ($users) {
                foreach ($users as $user) {
                    if ($user->userDocuments()) {
                        foreach ($user->userDocuments() as $filePath) {
                            if (file_exists(storage_path('app/'.$filePath->file_path))) { 
                                unlink(storage_path('app/'.$filePath->file_path));
                            }
                        }
                        $user->userDocuments()->delete();
                    }
                    $user->delete();
                }
                Log::info('Selected users deleted successfully');
                return $this->sendResponse([], 'Selected users deleted successfully.');
            } else {
                return $this->sendError('users not found.');
            }
        } catch (Exception $e) {
            Log::error('Failed to delete users due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('Operation failed to delete users.');
        }
    }

}
