<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class LoginRegisterController extends Controller
{
    // login instance
    public function __construct() {
        $this->middleware('guest')->except(['logout','dashboard']);
    }

    // Registration
    public function register(){
        return view ('auth.register');
    }

    // Store users data
    public function store(Request $request){
        $request->validate([
            'name' => 'required|String|max:250',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
            ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
            ]);

        $credentials = $request->only('email','password');
        if (Auth()->attempt($credentials)) {
            session()->regenerate();
            return redirect('/dashboard')->withSuccess('You have successfully registered and logged in!');
        }else{
            return back()->withErrors('Email or Password is incorrect! Please try again.');
        }

    }

    // Login
    public function login(){
        return view ('auth.login');
    }

    // Authenticate the Users credentials
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
            ]);

        if(Auth::attempt($credentials)){
            $request->session()->generate();
            return redirect()->route('dashboard')->withSccess('You have successfully loged in.');
        }else{
            return back()->withErrors(['email','You provided credentials do not match in our records.'])
            ->onlyInput('email');
        }
    }

    // Display the Dashboard to Authenticated users.
    public function dashboard(){
        if(Auth::check()){
            return view('auth.dashboard');
        }else{
            return redirect('/login')->withErrors(['email','Please login to access to the dashboard!'])
            ->onlyInput('email');
        }
    }

    // Logout user from the Application

    public function logout(Request $request):RedirectResponse {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

// Controller end here..    
}
