<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    
    public function save(Request $request){


        if(Auth::check()){
            return redirect(route('user.todos'));
        }

        $validateFields = $request->validate([
            'email' => 'required|email',
            "password" => 'required'
        ]);

        if(User::where('email', $validateFields['email'])->exists()){

            return redirect(route('user.register'))->withErrors([

            'email' => 'Такой пользователь уже зарегистрирован'

        ]);
    }

        $user = User::create($validateFields);
        if($user){
             Auth::login($user);
             return redirect(route('user.todos'));
        }
        

        return redirect(route('user.login'))->withErrors([
            'formError' => 'Произошла ошибка при сохранении пользователя'
        ]);
    }
}
