<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DeliveryPersonnel
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        if (!auth()->user()->isDelivery()) {
            abort(403, 'Unauthorized - Delivery personnel only.');
        }
        
        // Check if delivery profile exists
        if (!auth()->user()->deliveryPersonnel) {
            abort(403, 'Delivery profile not found. Please contact support.');
        }
        
        return $next($request);
    }
}