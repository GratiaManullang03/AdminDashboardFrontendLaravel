<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        try {
            $response = Http::post(env('ADMIN_API_URL') . '/api/auth/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Store token and user data in session
                Session::put('token', $data['token']);
                Session::put('user_id', $data['user']['id']);
                Session::put('user_name', $data['user']['name']);
                Session::put('user_email', $data['user']['email']);
                Session::put('user_roles', $data['user']['roles']);
                
                return redirect()->route('dashboard')->with('success', 'Login successful!');
            }
            
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Connection error: ' . $e->getMessage())->withInput();
        }
    }
    
    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'You have been logged out!');
    }
}