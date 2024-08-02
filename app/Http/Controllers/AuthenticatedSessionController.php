<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        $user = $request->only('email', 'password');
        if (Auth::attempt($user)) {
            $request->session()->regenerate();
    
            $redirectTo = $this->redirectToBasedOnUserType(Auth::user()->user_type);
    
            return redirect()->intended($redirectTo);
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    
    protected function redirectToBasedOnUserType($userType)
    {
        switch ($userType) {
            case 'Admin':
                return '/admin'; 
            case 'Customer':
                return '/customer';
            case 'Seller':
                return '/seller'; 
            default:
                return '/';
        }
    }
}
