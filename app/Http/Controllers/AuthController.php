<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password'=>'required|string|min:6|confirmed'
            ]);
            
            $user = User::create([
                'name'=> $request->name,
                'email'=>$request->email,
                'password'=> Hash::make($request->password)
            ]);
    
            Auth::login($user);
    
            return view('dashboard', compact('user'));
        } catch (\Exception $e) {
            return back()->withErrors(['register'=>'Something went wrong!']);
        }

    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=> 'required|email',
            'password'=> 'required'
        ]);
        if(Auth::attempt($request->all())) {
            return view('dashboard', compact('user'));
        } else {
            return back()->withErrors(['login' => 'Invalid credentials']);
        }
        
    }
    public function logout()
    {
        Auth::logout();
        return view('welcome',['success'=>'Logged out successfully!']);
    }
}