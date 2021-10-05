<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Support\Facades\Validator;
class userController extends Controller
{
    /**
     * Register user
     * Request $request
     * @returns Boolean $result
     */

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => "required",
            'email' => "required|email",
            "password" => "required|min:8"
        ]);

        if($validator->fails()){
            return response()->json([
                "status"=>400,
                "message"=>"Bad request"
            ],400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->roles = ['admin'];
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            "status"=>200,
            "message"=>"Success"
        ],200);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => "required|email",
            "password" => "required"
        ]);

        if($validator->fails()){
            return response()->json([
                "status"=>400,
                "message"=>"Bad request"
            ],400);
        }

        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                "status"=>401,
                "message"=>"Unauthorized"
            ],401);
        }

        $user = User::where("email",$request->email)->select('id','name','email')->first();
        $token = $request->user()->createToken('user-token')->plainTextToken;
        Arr::add($user,'token',$token);
        return response()->json($user);
    }

    public function allUser(Request $request){
        return response()->json(['users'=>$request->user()]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
    }
}
