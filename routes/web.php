<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SupervisorsController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

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

Route::controller(LoginController::class)->group(function(){
    Route::get('/','index')->name('i_login');
    Route::post('login','login')->name('login');
    Route::get('logout','logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function(){
    Route::get('registro','index')->name('i_register');
    Route::post('registro','register')->name('register');
});

Route::middleware(Authenticate::class)->group(function(){
    Route::controller(SupervisorsController::class)->group(function () {
        Route::get('supervisores', 'index')->name('supervisores');
        Route::post('supervisores/crear', 'createNote')->name('create_note');
        Route::post('supervisores/editar', 'editNote')->name('edit_note');
        Route::post('supervisores/nota', 'getNote')->name('get_note');
        Route::post('supervisores/eliminar', 'deleteNote')->name('delete_note');
    });

    Route::controller(AdminController::class)->group(function () {
        Route::get('admin', 'index')->name('admin');

        Route::post('admin/create-user', 'createUser')->name('create-user');
        Route::post('admin/get-user', 'getUser')->name('get-user');
        Route::post('admin/edit-user', 'editUser')->name('edit-user');
        Route::post('admin/cambiar-status', 'toggleStatusUser')->name('toggleStatus');

        Route::post('admin/create-oven', 'createOven')->name('create-oven');
        Route::post('admin/get-oven', 'getOven')->name('get-oven');
        Route::post('admin/edit-oven', 'editOven')->name('edit-oven');
        Route::post('admin/status-oven', 'toggleStatusOven')->name('toggleStatusOven');

        Route::post('admin/create-area', 'createArea')->name('create-area');
        Route::post('admin/get-area', 'getArea')->name('get-area');
        Route::post('admin/edit-area', 'editArea')->name('edit-area');
        Route::post('admin/status-area', 'toggleStatusArea')->name('toggleStatusArea');


    });
});

Route::controller(NotesController::class)->group(function () {
    Route::get('notas', 'index')->name('notas');
    Route::post('notes/done', 'doneNote')->name('done.note');
});

