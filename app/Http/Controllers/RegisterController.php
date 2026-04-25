<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DeliveryPersonnel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|in:user,delivery', 
            
            // Delivery personnel specific fields
            'phone_number' => 'required_if:role,delivery|nullable|string|max:20',
            'vehicle_type' => 'required_if:role,delivery|nullable|in:motorcycle,car,bicycle',
            'license_plate' => 'required_if:role,delivery|nullable|string|max:20',
        ], [
            'phone_number.required_if' => 'Phone number is required for delivery personnel.',
            'vehicle_type.required_if' => 'Vehicle type is required for delivery personnel.',
            'license_plate.required_if' => 'License plate is required for delivery personnel.',
            'role.required' => 'Please select an account type.',
        ]);

        try {
            DB::beginTransaction();
            
            // Create the user
            $user = User::create([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'is_active' => true,
            ]);

        
            if ($validated['role'] === 'delivery') {
                DeliveryPersonnel::create([
                    'user_id' => $user->id,
                    'phone_number' => $validated['phone_number'],
                    'vehicle_type' => $validated['vehicle_type'],
                    'license_plate' => $validated['license_plate'],
                    'availability_status' => 'available',
                    'total_deliveries' => 0,
                    'rating' => 5.00,
                    'rating_count' => 0,
                ]);
                
                Log::info('New delivery personnel registered', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'vehicle_type' => $validated['vehicle_type']
                ]);
                
                DB::commit();
                
                return redirect()->route('login')
                    ->with('success', 'Delivery account created successfully! Please login to start delivering.');
            }
            
            // Regular customer registration
            Log::info('New customer registered', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
            
            DB::commit();
            
            return redirect()->route('login')
                ->with('success', 'Account created successfully! Please login to continue.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration failed: ' . $e->getMessage(), [
                'email' => $request->email,
                'role' => $request->role,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withErrors(['email' => 'Registration failed: ' . $e->getMessage()])
                ->withInput();
        }
    }
}