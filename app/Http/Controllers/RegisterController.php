<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'userName' => ['required'],
            'user' => ['required', 'unique:users,user'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $user = new User();
        $user->name = $request->userName;
        $user->user = $request->user;
        $user->status = 1;
        $user->rol = 2;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect(route('i_login'))->with('success', 'El usuario se creo correctamente');
        } else {
            return redirect(route('i_register'))->with('error', 'El usuario no se pudo crear correctamente, hable con el administrador del sistema');
        }
    }
}
