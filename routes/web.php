<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


// Auth routes
Route::get('login', [LoginController::class , 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class , 'login']);
Route::post('logout', [LoginController::class , 'logout'])->name('logout');

// Registration Routes...
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group([

    'middleware' => 'web',
    'prefix' => 'auth'

], function ($router) {

    // User
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('userList', [UserController::class, 'userList'])->name('user.list');
    Route::get('showus/{id}', [UserController::class, 'show'])->name('user.show');
    Route::put('updateus/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('deleteus/{id}', [UserController::class, 'delete'])->name('user.delete');

    // Task
    Route::get('/tk', [TaskController::class, 'index'])->name('tk.index');
    Route::get('/showtk/{id}', [TaskController::class, 'show'])->name('tk.show');
    Route::post('/createtk', [TaskController::class, 'store'])->name('tk.create');
    Route::put('updatetk/{id}', [TaskController::class, 'update'])->name('tk.update');
    Route::delete('deletetk/{id}', [TaskController::class, 'delete'])->name('tk.delete');

    // Tags
    Route::get('tg', [TagsController::class, 'index'])->name('tg.index');
    Route::get('tagsList', [TagsController::class, 'tagsList'])->name('tg.list');
    Route::get('showtgl/{id}', [TagsController::class, 'show'])->name('tg.show');
    Route::post('createtg', [TagsController::class, 'store'])->name('tg.create');
    Route::put('updatetg/{code}', [TagsController::class, 'update'])->name('tg.update');
    Route::delete('deletetg/{id}', [TagsController::class, 'delete'])->name('tg.delete');

});
