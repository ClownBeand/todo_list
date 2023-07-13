<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::redirect('/', '/login');

Route::resource('todos', TodoController::class)->except(['destroy']);
Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');

Route::name('user.')->group(function() {
    Route::view('/todos','todo')->middleware('auth')->name('todos');

    Route::get('/login', function () {
        if (Auth::check()) {
            return redirect(route('user.todos'));
        }

        return view('login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/logout', function(){
        Auth::logout();
        return redirect('/login');
    })->name('logout');

    Route::get('/register', function () {
        if (Auth::check()) {
            return redirect(route('user.todos'));
        }

        return view('register');
    })->name('register');

    Route::post('/register', [RegisterController::class, 'save'])->name('register');
});
