<?php

use App\Http\Controllers\chatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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

    Route::get("user/{username}", function(string $username) {
        $user = User::select("username", "photo", "id")
                    ->where("username", $username)
                    ->get();
        return $user;
    });

    Route::post("/sendMessage", [chatController::class, "sendMessage"])
        ->name("send.message");

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
