<?php

use App\Http\Controllers\Admin\AdminActingController;
use App\Http\Controllers\Auth\AuthAdminController;
use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Post\PostController;
use Illuminate\Support\Facades\Route;

Route::post('v1/user/register',[AuthUserController::class,'register']);
Route::post('v1/user/login',[AuthUserController::class,'login']);
Route::post('v1/admin/login',[AuthAdminController::class,'login']);
Route::apiResource('v1/post',PostController::class)->middleware(['auth:sanctum','auth:admin']);

Route::middleware(['auth:admin','AutherizedAdmin'])->group(function (){
    Route::post('v1/admin/user',[AdminActingController::class,'addUser']);
    Route::get('v1/admin/user',[AdminActingController::class,'getUsers']);
    Route::put('v1/admin/user',[AdminActingController::class,'updateUser']);
    Route::put('v1/users/number',[AdminActingController::class,'totalUser']);
    Route::delete('v1/admin/user',[AdminActingController::class,'deleteUser']);
});




