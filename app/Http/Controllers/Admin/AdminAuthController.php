<?php

namespace App\Http\Controllers\Admin;


use Auth;
use Validator;
use Tymon\JWTAuth\JWT;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class AdminAuthController extends Controller
{
    use GeneralTrait;

    public function login(Request $request){
        try {
            //validation
            $rules=[
                'username' => 'required|exists:admins',
                'password' => 'required'
            ];
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code,$validator);
            }

            //login
            $credentials = $request->only(['username','password']);
            $token = Auth::guard('admin-api')->attempt($credentials);
            if(!$token){
                //return $this->returnError('E001','Credentials is not correct');
                return $token;
            }

            //return token
            //return $this->returnData('token',$token);
            //return data with token
            $admin = Auth::guard('admin-api')->user();
            $admin->token = $token;
            return $this->returnData('admin',$admin);
        } catch (\Exception $e) {
            return $this->returnError($e->getCode(),$e->getMessage());
        }
        
    }
    public function logout(Request $request){
        $token = $request -> header('token');
        if($token){
            try {

                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('','Something went wrongs');
            }
            return $this->returnSuccess('Logged out successfully');
        }else{
            $this -> returnError('','Something went wrongs');
        }

    }

        
    public function logout2()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    
}
