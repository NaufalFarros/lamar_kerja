<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\TodoListController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// group middleware auth

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [NoteController::class, 'dashboard'])->name('dashboard');
    Route::get('/note', [NoteController::class, 'index'])->name('note');
    Route::post('/note', [NoteController::class, 'store'])->name('notes.store');
    Route::put('/note/{id}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/note/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');
    Route::get('/note/{id}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    
    
    Route::get('/todolist', [TodoListController::class, 'index'])->name('todolist');
    Route::get('/todolist/fetch', [TodoListController::class, 'fetch'])->name('todolists.fetch');
    Route::post('/todolist', [TodoListController::class, 'store'])->name('todolists.store');
    Route::put('/todolist/{id}', [TodoListController::class, 'update'])->name('todolists.update');
    Route::delete('/todolist/{id}', [TodoListController::class, 'destroy'])->name('todolists.destroy');
});

