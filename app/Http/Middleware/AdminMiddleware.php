<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();
        
        // Check if user is admin
        if ($user->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access. Admin privileges required.');
        }

        return $next($request);
    }
}