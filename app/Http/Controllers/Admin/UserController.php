<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }
        
        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Stats
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'customer_users' => User::where('role', 'user')->count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
        ];
        
        return view('admin.users.index', compact('users', 'stats'));
    }
    
    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }
    
    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
            'is_active' => 'boolean',
        ]);
        
        try {
            DB::beginTransaction();
            
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_active' => $request->is_active ?? true,
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User creation error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create user. Please try again.');
        }
    }
    
    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load(['orders' => function($query) {
            $query->latest()->limit(10);
        }]);
        
        $orderStats = [
            'total_orders' => $user->orders()->count(),
            'total_spent' => $user->orders()->where('status', 'completed')->sum('total'),
            'average_order' => $user->orders()->where('status', 'completed')->avg('total'),
            'last_order' => $user->orders()->latest()->first(),
        ];
        
        return view('admin.users.show', compact('user', 'orderStats'));
    }
    
    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
            'is_active' => 'boolean',
        ]);
        
        try {
            DB::beginTransaction();
            
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->role = $request->role;
            $user->is_active = $request->is_active ?? $user->is_active;
            
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            $user->save();
            
            DB::commit();
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update user. Please try again.');
        }
    }
    
    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Prevent deleting yourself
            if ($user->id === auth()->id()) {
                return back()->with('error', 'You cannot delete your own account.');
            }
            
            // Check if user has orders
            if ($user->orders()->exists()) {
                return back()->with('error', 'Cannot delete user with existing orders. Consider deactivating instead.');
            }
            
            $user->delete();
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully.');
                
        } catch (\Exception $e) {
            Log::error('User deletion error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete user. Please try again.');
        }
    }
    
    /**
     * Toggle user active status.
     */
    public function toggleStatus(User $user)
    {
        try {
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot change your own status.'
                ], 400);
            }
            
            $user->is_active = !$user->is_active;
            $user->save();
            
            return response()->json([
                'success' => true,
                'is_active' => $user->is_active,
                'message' => 'User status updated successfully.'
            ]);
            
        } catch (\Exception $e) {
            Log::error('User status toggle error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user status.'
            ], 500);
        }
    }
    
    /**
     * Export users to CSV.
     */
    public function export(Request $request)
    {
        $users = User::query();
        
        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $users->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('role')) {
            $users->where('role', $request->role);
        }
        
        $users = $users->orderBy('created_at', 'desc')->get();
        
        $filename = 'users_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Role', 'Status', 'Registered Date', 'Orders Count', 'Total Spent']);
            
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->first_name . ' ' . $user->last_name,
                    $user->email,
                    $user->phone,
                    $user->role,
                    $user->is_active ? 'Active' : 'Inactive',
                    $user->created_at->format('Y-m-d H:i:s'),
                    $user->orders()->count(),
                    number_format($user->orders()->where('status', 'completed')->sum('total'), 2),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}