<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    // Login
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('user-profile', [AuthController::class, 'userProfile']);
 
     // Task
     Route::get('/tk', [TaskController::class, 'index'])->name('tk.index');
     Route::get('/showtk/{id}', [TaskController::class, 'show'])->name('tk.show');
     Route::post('/createtk', [TaskController::class, 'store'])->name('tk.create');
     Route::put('updatetk/{id}', [TaskController::class, 'update'])->name('tk.update');
     Route::delete('deletetk/{id}', [TaskController::class, 'delete'])->name('tk.delete');

});
