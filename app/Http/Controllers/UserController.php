<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;
class UserController extends Controller
{
  /*  public function register(Request $request){
    $data =$request->all();
    }*/
   public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "email" => 'required|email|unique:users,email',
                'name' => 'required|string|min:2',
                "password" => "string|required|min:6"
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'result' => null,
                    'message' => $validator->errors(),
                ], 200);
            }
            else{
            $user =new User;
            $user->email=$request->email;
            $user->name=$request->name;
            $user->password=Hash::make($request['password']);
            $user->save();
            }


        } catch (Exception $e) {
            return response()->json([
                'status'=>'failed',
                'validator errors'=>$validator->errors(),
                'Exceptions'=>$e
            ],200);
        }
    }
    function registerr(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "email" => 'required|email|unique:users,email',
                'name' => 'required|string|min:2',
                "password" => "string|required|min:6|confirmed"
            ]);


            $user =new User;
            $user->email=$request->email;
            $user->name=$request->name;
            $user->password=Hash::make($request['password']);
            $user->save();



            if ($user) {
                return $this->responseWithToken(auth()->login($user), $user);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'An error occure while trying to create user'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'=>'failed',
                'validator errors'=>$validator->errors(),
                'Exceptions'=>$e
            ],200);
        }
    }
    function responseWithToken($token, $user)
    {
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'access_token' => $token
        ],200);
    }
}
