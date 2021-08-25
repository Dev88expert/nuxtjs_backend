<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
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

// Auth routes
Route::post('login',[AuthController::class, 'login']);
Route::post('register',[AuthController::class, 'register']);

// todo auth routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('todos',[TodoController::class,'getTodo']);
    Route::post('add/todo',[TodoController::class,'addTodo']);
    Route::get('get/todo/{id}',[TodoController::class,'fetchTodoById']);
    Route::post('update/todo/{id}',[TodoController::class,'updateTodo']);
    Route::post('delete/todo',[TodoController::class,'deleteTodo']);
    Route::post('auth-logout',[AuthController::class,'Logout']);


    Route::post('todo-status/{id}',[TodoController::class,'completed']);
    Route::post('check-all-todos',[TodoController::class,'checkedAll']);
    

});