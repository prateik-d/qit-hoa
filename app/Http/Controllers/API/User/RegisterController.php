<?php
   
namespace App\Http\Controllers\API\User;
   
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\City;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\User as UserResource;
   
class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(StoreUserRequest $request)
    {
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
            return $this->sendResponse(new UserResource($user), 'User created successfully.');
        } else {
            return $this->sendError('Failed to add user');      
        }
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->first_name;
            $user = User::where('email', $request->email)->update(['remember_token' => $success['token'], 'email_verified_at' => now()]);
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.'], 200);
    }
}