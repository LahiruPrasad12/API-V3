<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            "status"=>200,
            "message"=>"Success"
        ],200);
    }
}
