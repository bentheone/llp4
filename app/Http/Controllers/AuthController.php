<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'names' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password'=>'required|string|min:6'
            ]);
            
            $user = User::create([
                'names'=> $request->names,
                'email'=>$request->email,
                'password'=> Hash::make($request->password)
            ]);
    
            Auth::login($user);
    
            return redirect('/dashboard')->with('user', auth()->user());
        } catch (\Exception $e) {
            
            return back()->withErrors(['register'=>$e->getMessage()]);
        }

    }

    public function login(Request $request)
    {
        try{
            $credentials = $request->validate([
            'email'=> 'required|email',
            'password'=> 'required'
        ]);
        if(Auth::attempt($credentials)) {
            return redirect('/dashboard')->with('user', auth()->user());
        } else {
            return back()->withErrors(['login' => 'Invalid credentials!']);
        }
    }catch(\Exception $e) {
        return back()->withErrors(['login' => $e->getMessage()]);
    }
        
    }
    public function logout(Request $request)
    {
        Auth::logout();                    
        Session::flush();                 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}