<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Staff;
use App\Models\Client;
use App\Models\Logs;
use App\Models\Student;

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

    public function checkIn(Request $request)
    {
        $uuid = $request->input('uuid'); // Retrieve UUID from the GET request
    
        Log::channel('check_in_logs')->info("UUID value is: " . $uuid);
    
        $user = Student::where('uuid', $uuid)->first();
    
        if (!$user) {
            $user = Staff::where('uuid', $uuid)->first();
        }
    
        if ($user) {
            Log::channel('check_in_logs')->info("User " . $user->full_name . " scanned card", [
                "full_name" => $user->full_name,
                "uuid" => $uuid,
                "user_type" => $user->user_type,
                "state" => "in",
                "time_in" => now()
            ]);
    
            Logs::create(
                [
                    "full_name" => $user->full_name,
                    "uuid" => $uuid,
                    "user_type" => $user->user_type,
                    "state" => 'in',
                    "time" => now()
                ]
            );
    
            return response()->json([
                'status' => 'success',
                'message' => 'Authorized access',
                'user' => $user->full_name,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
            ]);
        }
    }
    
    public function checkOut(Request $request)
    {
        $uuid = $request->input('uuid'); // Retrieve UUID from the GET request
    
        Log::channel('check_out_logs')->info("UUID value is: " . $uuid);
    
        $user = Student::where('uuid', $uuid)->first();
    
        if (!$user) {
            $user = Staff::where('uuid', $uuid)->first();
        }
    
        if ($user) {
            Log::channel('check_out_logs')->info("User " . $user->full_name . " scanned card", [
                "full_name" => $user->full_name,
                "uuid" => $uuid,
                "user_type" => $user->user_type,
                "state" => "out",
                "time" => now()
            ]);
    
            Logs::create(
                [
                    "full_name" => $user->full_name,
                    "uuid" => $uuid,
                    "user_type" => $user->user_type,
                    "state" => 'out',
                    "time" => now()
                ]
            );
    
            return response()->json([
                'status' => 'success',
                'message' => 'Authorized access',
                'user' => $user->full_name,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
            ]);
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
