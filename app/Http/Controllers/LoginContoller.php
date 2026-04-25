<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['sometimes', 'required', 'in:customer,delivery,admin']
        ]);

        // Get the intended role from the request (default to customer)
        $intendedRole = $request->input('role', 'customer');

        // Log the login attempt
        Log::info('Login attempt', [
            'email' => $request->email,
            'intended_role' => $intendedRole
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Log user details after authentication
            Log::info('User authenticated', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'is_delivery' => $user->isDelivery(),
                'is_admin' => $user->isAdmin()
            ]);
            
            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                Log::warning('Login attempt on inactive account', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role
                ]);
                return back()->withErrors([
                    'email' => 'Your account has been deactivated. Please contact support.',
                ]);
            }
            
         
            if ($intendedRole === 'delivery' && !$user->isDelivery()) {
                Auth::logout();
                Log::warning('Non-delivery user attempted delivery login', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'user_role' => $user->role,
                    'intended_role' => $intendedRole
                ]);
                return back()->withErrors([
                    'email' => 'This account is not registered as delivery personnel. Please use customer login.',
                ]);
            }
            
            if ($intendedRole === 'customer' && $user->isDelivery()) {
                Auth::logout();
                Log::warning('Delivery user attempted customer login', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'user_role' => $user->role,
                    'intended_role' => $intendedRole
                ]);
                return back()->withErrors([
                    'email' => 'This account is for delivery personnel only. Please use delivery login.',
                ]);
            }
            
            // Log successful login with role
            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'login_type' => $intendedRole,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            // ROLE-BASED REDIRECTION
            if ($user->role === 'admin') {
                Log::info('Redirecting to admin dashboard');
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin ' . $user->first_name . '!');
            }
            
            if ($user->role === 'delivery') {
                Log::info('Redirecting to delivery dashboard');

                return redirect()->route('delivery.dashboard')->with('success', 'Welcome back, ' . $user->first_name . '!');
            }
            
           
            Log::info('Redirecting to landing page');
            return redirect()->route('landing')->with('success', 'Welcome back, ' . $user->first_name . '!');
        }

        // Log failed login attempt
        Log::warning('Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        
        Log::info('User logged out', [
            'user_id' => $user->id ?? null,
            'email' => $user->email ?? null,
            'role' => $user->role ?? null,
            'ip' => $request->ip()
        ]);
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('welcome')->with('success', 'You have been logged out successfully.');
    }
}