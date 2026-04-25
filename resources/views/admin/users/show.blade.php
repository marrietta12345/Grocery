@extends('admin.layouts.admin')

@section('title', 'User Details - ' . $user->first_name . ' ' . $user->last_name)
@section('page-title', 'User Details')

@section('content')
<div class="container-fluid">
    <!-- User Profile Header -->
    <div class="content-card">
        <div class="d-flex justify-content-between align-items-start">
            <div class="d-flex gap-3">
                <div class="user-avatar-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                </div>
                <div>
                    <h2>{{ $user->first_name }} {{ $user->last_name }}</h2>
                    <p class="text-muted mb-1">{{ $user->email }}</p>
                    <p class="text-muted">{{ $user->phone ?? 'No phone number' }}</p>
                    <div class="mt-2">
                        @if($user->is_active)
                            <span class="badge-success">Active Account</span>
                        @else
                            <span class="badge-danger">Inactive Account</span>
                        @endif
                        @if($user->role == 'admin')
                            <span class="badge-success">Administrator</span>
                        @else
                            <span class="badge-info">Customer</span>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary-custom">
                    <i class="bi bi-pencil"></i> Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-custom">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Order Statistics -->
        <div class="col-md-4">
            <div class="content-card">
                <h4>Order Statistics</h4>
                <hr>
                <div class="mb-3">
                    <label class="text-muted">Total Orders</label>
                    <h3>{{ $orderStats['total_orders'] ?? 0 }}</h3>
                </div>
                <div class="mb-3">
                    <label class="text-muted">Total Spent</label>
                    <h3>₱{{ number_format($orderStats['total_spent'] ?? 0, 2) }}</h3>
                </div>
                <div class="mb-3">
                    <label class="text-muted">Average Order Value</label>
                    <h3>₱{{ number_format($orderStats['average_order'] ?? 0, 2) }}</h3>
                </div>
                @if($orderStats['last_order'] ?? false)
                <div>
                    <label class="text-muted">Last Order</label>
                    <p class="mb-0">{{ $orderStats['last_order']->created_at->format('M d, Y') }}</p>
                    <small class="text-muted">Order #{{ $orderStats['last_order']->order_number }}</small>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Account Information -->
        <div class="col-md-8">
            <div class="content-card">
                <h4>Account Information</h4>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="120"><strong>Full Name:</strong></td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td>{{ $user->phone ?? 'Not provided' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Role:</strong></td>
                                <td>{{ ucfirst($user->role) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="120"><strong>Status:</strong></td>
                                <td>{{ $user->is_active ? 'Active' : 'Inactive' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Joined:</strong></td>
                                <td>{{ $user->created_at->format('F d, Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Last Updated:</strong></td>
                                <td>{{ $user->updated_at->diffForHumans() }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email Verified:</strong></td>
                                <td>{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'Not verified' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Orders -->
    <div class="content-card">
        <div class="card-header">
            <h3>Recent Orders</h3>
            <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}" class="btn btn-sm btn-outline-custom">
                View All Orders <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->orders()->latest()->limit(5)->get() as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>₱{{ number_format($order->total, 2) }}</td>
                        <td>
                            @php
                                $statusClass = match($order->status) {
                                    'completed' => 'badge-success',
                                    'pending' => 'badge-warning',
                                    'processing' => 'badge-info',
                                    'cancelled' => 'badge-danger',
                                    default => 'badge-info'
                                };
                            @endphp
                            <span class="{{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>
                            @php
                                $paymentClass = match($order->payment_status) {
                                    'paid' => 'badge-success',
                                    'unpaid' => 'badge-warning',
                                    'refunded' => 'badge-info',
                                    default => 'badge-warning'
                                };
                            @endphp
                            <span class="{{ $paymentClass }}">{{ ucfirst($order->payment_status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-custom">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="mt-2 text-muted">No orders yet</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection