<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request){
        $formFields = $request->only(['email', 'password']);
       // dd($formFields); // Отладочный вывод

        if(Auth::check()){
           // return redirect()->intended(route('todos.index'));
           return redirect()->route('user.todos');

        }

        if(Auth::attempt($formFields)){
          // return redirect()->intended(route('todos.index'));
            return redirect()->route('user.todos');

        }

        return redirect(route('user.login'))->withErrors([
            'email' => 'Не удалось авторизоваться'
        ]);
    }

    public function show(User $user)
    {
        return $user->email;
    }
}
