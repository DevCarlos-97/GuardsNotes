<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'user' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('user','password');

        $user = User::where('user',$request->user)->get();

        if ($user[0]->status == 3) {
            return redirect(route('i_login'))->with('status', 'El usuario esta deshabilitado');
        }else {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user = Auth::user();
                $request->session()->put('user_id', $user->id);
                
                switch ($user->rol) {
                    case 1:
                        return redirect(route('notas'));
                        break;
    
                    case 2:
                        return redirect()->intended(route('supervisores'));
                        break;
    
                    case 3:
                        return redirect()->intended(route('admin'));
                        break;
                }
                
            }
        }

        return redirect(route('i_login'))->with('error', 'El usuario o la contraseña no son correctas');
    }

    public function logout() {
        Auth::logout();
        return redirect(route('i_login'));
    }
}
