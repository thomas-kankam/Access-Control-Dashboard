<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function signin()
    {
        return view('authentication.login');
    }

    public function login(Request $request)
    {
        try {
            $rules = [
                "email" => "required|email",
                "password" => "required"
            ];

            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $credentials = $request->only(['email', 'password']);
            if (Auth::attempt($credentials)) {
                Log::channel('login')->info('Login successful with credentials from ' . $request->email . ' at timestamp -> ' . date('Y-m-d H:i:s'));
                return redirect()->intended('/dashboard');
            } else {
                Log::channel('login')->error('Failed login attempt with credentials from ' . $request->only(['email']) . ' at timestamp -> ' .  date('Y-m-d H:i:s'));
                return redirect()->back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ])->withInput();
            }
        } catch (\Exception $e) {
            Log::channel('login')->error('LOGIN_ERROR: ' . $e->getMessage() . ' - at timestamp -> ' . date('Y-m-d H:i:s'));
            return redirect()->back()->with('error', 'Sorry, the sign-in process encountered a problem!');
        }
    }

    public function logout()
    {
        auth()->logout();
        $email = request('email');
        Log::channel('logout')->info('logout successful for email: ' . $email . ' - at timestamp -> ' . date('Y-m-d H:i:s'));
        return redirect()->route('auth.signin');
    }
}
