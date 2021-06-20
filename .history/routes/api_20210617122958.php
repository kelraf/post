<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\authController;
use App\Http\Controllers\postsController;

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

Route::post("/user-data", [userController::class, "store"]);
Route::post("/user-data/auth-login", [authController::class, "login"]);

Route::group(["middleware" => ["auth:sanctum"]], function() {

    // User Data Endpoints
    Route::get("/user-data/{id}", [userController::class, "show"]);
    Route::get("/user-data", [userController::class, "index"]);
    Route::put("/user-data/update-name/{id}", [userController::class, "update_name"]);
    Route::put("/user-data/update-email/{id}", [userController::class, "update_email"]);
    Route::put("/user-data/update-password/{id}", [userController::class, "update_password"]);
    Route::delete("/user-data/{id}", [userController::class, "destroy"]);

    // Posts Data Endpoints

    Route::get("/posts", [postsController::class, "index"]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
