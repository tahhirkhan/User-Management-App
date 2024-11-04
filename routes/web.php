<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('addUserForm');
// });

Route::get('/',[App\Http\Controllers\UserController::class, 'addUserForm'])->name('addUserForm');
Route::get('/showAllUsers',[App\Http\Controllers\UserController::class, 'showAllUsers'])->name('showAllUsers');
Route::post('/submitAddUserForm',[App\Http\Controllers\UserController::class, 'submitAddUserForm'])->name('submitAddUserForm');
Route::post('/updateUserDetails',[App\Http\Controllers\UserController::class, 'updateUserDetails'])->name('updateUserDetails');
Route::get('/deleteUser/{id}',[App\Http\Controllers\UserController::class, 'deleteUser'])->name('deleteUser');