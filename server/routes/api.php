<?php

use Illuminate\Http\Request;
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

Route::post("cells/{id}/update_chief", "CellController@update_chief");
Route::post("cells/{id}/delete_chief", "CellController@delete_chief");
Route::post("cells/{id}/add_member", "CellController@add_member");
Route::post("cells/{id}/delete_member", "CellController@delete_member");

Route::apiResources([
    'users' => "UserController",
    "posts" => "PostController",
    "cells" => "CellController",
    "meetings" => "MeetingController"
]);