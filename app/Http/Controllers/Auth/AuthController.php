<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register_view()
    {
        return view('auth.register');
    }

  public function register(RegisterRequest $request)
    {
        User::create($request->validated());
        return '1';
    }


    public function login_view()
    {
        return view('auth.login');
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => request('data'), 'password' => request('password')])){
            return redirect()->route('transactions.index');
        }

        return back()->withErrors(['message' => 'Wrong credentials']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

}
