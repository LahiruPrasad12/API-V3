<?php

use Illuminate\Http\Request;
use \App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[userController::class,'register']);
Route::post('/login',[userController::class,'login']);


/*Normal authentication part*/
Route::group(['middleware'=>['auth:sanctum']],function (){
    Route::get('/getData',[userController::class,'allUser']);
    Route::get('/logout',[userController::class,'logout']);
    Route::get('/checkAdmin',[userController::class,'checkAdmin']);
});


/*Fortify and sanctum authentication part*/
Route::group(['middleware'=>['auth:sanctum']],function (){
    Route::get('/',function (){
        return response()->json([
            "status" => 200,
            "Message" => "Success"
        ],200);
    });
});


