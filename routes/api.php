<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChatApiController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/index', [ChatApiController::class, 'index']);
Route::post('/user_list', [ChatApiController::class, 'user_list']);
Route::post('/send_message', [ChatApiController::class, 'send_message']);
Route::post('/send_list', [ChatApiController::class, 'send_list']);