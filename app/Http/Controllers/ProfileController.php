<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
        
        return view('profile', compact('user', 'addresses'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update($request->only('first_name', 'middle_name', 'last_name', 'email'));

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'address_type' => 'required|in:home,work,other',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'delivery_instructions' => 'nullable|string',
            'is_default' => 'sometimes|boolean',
        ]);

        // If this is set as default, remove default from other addresses
        if ($request->has('is_default') && $request->is_default) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        $address = new Address($request->all());
        $address->user_id = Auth::id();
        $address->save();

        return redirect()->route('profile')->with('success', 'Address added successfully!');
    }

    public function updateAddress(Request $request, Address $address)
    {
        // Check if address belongs to user
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'address_type' => 'required|in:home,work,other',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'delivery_instructions' => 'nullable|string',
            'is_default' => 'sometimes|boolean',
        ]);

        // If this is set as default, remove default from other addresses
        if ($request->has('is_default') && $request->is_default) {
            Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($request->all());

        return redirect()->route('profile')->with('success', 'Address updated successfully!');
    }

    public function deleteAddress(Address $address)
    {
        // Check if address belongs to user
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('profile')->with('success', 'Address deleted successfully!');
    }

    public function setDefaultAddress(Address $address)
    {
        // Check if address belongs to user
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        // Remove default from all addresses
        Auth::user()->addresses()->update(['is_default' => false]);
        
        // Set this as default
        $address->update(['is_default' => true]);

        return redirect()->route('profile')->with('success', 'Default address updated!');
    }
}