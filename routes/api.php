<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\adminMiddleware;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// public route
Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);
Route::get('me',[AuthController::class, 'me']);
Route::post('logout',[AuthController::class, 'logout']);

// CURD Users And Assign Role to users (admin only)
Route::middleware([adminMiddleware::class])->group(function(){
    Route::apiResource('user',UserController::class);
    Route::post('user/{user_id}/assignRole',[UserController::class, 'assignRoleToUser']);
});

// CRUD roles and Assign permission to role (admin or manager)
Route::middleware([RoleMiddleware::class])->group(function(){
    Route::apiResource('Role',RoleController::class);
    Route::post('Role/{role_id}/AssignPermissions',[RoleController::class ,'AssignPermissionToRole']);
});

// CRUD Permission (admin or manager)
Route::middleware([PermissionMiddleware::class])->group(function(){
    Route::apiResource('Permission',PermissionController::class);
});

