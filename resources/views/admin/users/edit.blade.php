@extends('admin.layouts.admin')

@section('title', 'Edit User - ' . $user->first_name . ' ' . $user->last_name)
@section('page-title', 'Edit User')

@section('content')
<div class="container-fluid">
    <div class="content-card">
        <div class="card-header">
            <h3>Edit User: {{ $user->first_name }} {{ $user->last_name }}</h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-custom">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>
        
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name *</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                           value="{{ old('first_name', $user->first_name) }}" required>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name *</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                           value="{{ old('last_name', $user->last_name) }}" required>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                           value="{{ old('phone', $user->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Leave blank to keep current password</div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Role *</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Customer</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="form-check mt-4">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" 
                               id="is_active" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active Account
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle"></i>
                <strong>Note:</strong> Changing a user's role will update their permissions immediately.
            </div>
            
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-custom">Cancel</a>
                <button type="submit" class="btn btn-primary-custom">Update User</button>
            </div>
        </form>
    </div>
</div>
@endsection