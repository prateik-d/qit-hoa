<?php

namespace App\Http\Controllers\API\User;
   
use Exception;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\StoreUserRequest;

class UserController extends BaseController
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProfile()
    {
        try {
            $user = Auth::guard('api')->user();
            Log::info('Showing user profile for user id: '.$user->id);
            return $this->sendResponse($user, 'User profile retrieved successfully.');
        } catch(ModelNotFoundException $e) {
            Log::error('Failed to retrieve user profile details due to occurance of this exception'.'-'. $e->getMessage());
            return $this->sendError('User profile not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $id)
    {
        //
    }

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
                return $this->sendResponse(UserResource::collection($users), 'Users data retrieved successfully.');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
