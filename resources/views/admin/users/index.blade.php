@extends('admin.layouts.admin')

@section('title', 'Manage Users - Grocery Mart Admin')
@section('page-title', 'Manage Users')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ $stats['total_users'] ?? 0 }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-label">Active Users</div>
            <div class="stat-value">{{ $stats['active_users'] ?? 0 }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-person-badge"></i>
            </div>
            <div class="stat-label">Admin Users</div>
            <div class="stat-value">{{ $stats['admin_users'] ?? 0 }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-calendar-plus"></i>
            </div>
            <div class="stat-label">New This Month</div>
            <div class="stat-value">{{ $stats['new_users_this_month'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="content-card mb-4">
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small mb-1">Search</label>
                <div class="search-box position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3" style="color: var(--slate-400); z-index: 10;"></i>
                    <input type="text" name="search" class="form-control ps-5" placeholder="Search by name, email, phone..." value="{{ request('search') }}" style="padding-left: 2.8rem !important;">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Role</label>
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Customer</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Date From</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Date To</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-1 d-flex gap-2">
                <button type="submit" class="btn-primary-custom flex-fill">Filter</button>
            </div>
            <div class="col-12 d-flex justify-content-between align-items-center mt-3">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn-outline-custom">
                        <i class="bi bi-x"></i> Reset
                    </a>
                    <a href="{{ route('admin.users.export') }}?{{ http_build_query(request()->query()) }}" class="btn-outline-custom">
                        <i class="bi bi-download"></i> Export
                    </a>
                </div>
                <a href="{{ route('admin.users.create') }}" class="btn-primary-custom">
                    <i class="bi bi-plus-lg"></i> Add New User
                </a>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="content-card">
        <div class="card-header d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0"><i class="bi bi-people me-2" style="color: var(--primary);"></i>Users List</h3>
            <span class="badge-success px-3 py-2">{{ $users->total() }} Total Users</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="60">ID</th>
                        <th>User</th>
                        <th width="200">Contact</th>
                        <th width="100">Role</th>
                        <th width="100">Status</th>
                        <th width="120">Joined Date</th>
                        <th width="80">Orders</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td><span class="fw-600">#{{ $user->id }}</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar-sm me-3" style="width: 45px; height: 45px; border-radius: 12px; overflow: hidden; background: linear-gradient(135deg, var(--primary), var(--dark)); display: flex; align-items: center; justify-content: center;">
                                    <span style="color: white; font-weight: 600; font-size: 1rem;">
                                        {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="fw-600">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <small class="text-muted">ID: {{ $user->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ $user->email }}</div>
                            <small class="text-muted">{{ $user->phone ?? 'No phone number' }}</small>
                        </td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-primary text-white px-3 py-2">Administrator</span>
                            @else
                                <span class="badge bg-info text-white px-3 py-2">Customer</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active ?? true)
                                <span class="badge bg-success text-white px-3 py-2">Active</span>
                            @else
                                <span class="badge bg-danger text-white px-3 py-2">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $user->created_at->format('M d, Y') }}</div>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <span class="badge bg-secondary text-white px-3 py-2">{{ $user->orders()->count() ?? 0 }} orders</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-info" title="View" style="width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Edit" style="width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id != auth()->id())
                                    <button type="button" class="btn btn-sm btn-outline-warning toggle-status" 
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->first_name }} {{ $user->last_name }}"
                                            data-active="{{ $user->is_active ?? true }}"
                                            title="{{ ($user->is_active ?? true) ? 'Deactivate' : 'Activate' }}"
                                            style="width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-{{ ($user->is_active ?? true) ? 'toggle-on' : 'toggle-off' }}"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-user" 
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->first_name }} {{ $user->last_name }}"
                                            style="width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-people" style="font-size: 4rem; color: var(--slate-300);"></i>
                            <h5 class="mt-3 text-muted">No Users Found</h5>
                            <p class="text-muted">Get started by adding your first user</p>
                            <a href="{{ route('admin.users.create') }}" class="btn-primary-custom">
                                <i class="bi bi-plus-lg"></i> Add User
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-end">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete user <strong id="deleteUserName"></strong>?</p>
                <p class="text-danger small">This action cannot be undone. The user will be permanently removed from the system.</p>
            </div>
            <div class="modal-footer">
                <form id="deleteUserForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger-custom">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Toggle Status Modal -->
<div class="modal fade" id="toggleStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Toggle User Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <span id="toggleAction"></span> user <strong id="toggleUserName"></strong>?</p>
                <p class="text-muted small">This will affect the user's ability to log in to the system.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-custom" id="confirmToggle">Confirm</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Table Styles */
    .table th {
        font-weight: 600;
        color: var(--slate-700);
        border-bottom-width: 2px;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    
    /* User Avatar */
    .user-avatar-sm {
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }
    
    .user-avatar-sm:hover {
        transform: scale(1.05);
    }
    
    /* Badge Styles */
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    
    /* Button Styles */
    .btn-sm {
        padding: 0;
        line-height: 1;
    }
    
    .btn-outline-info:hover,
    .btn-outline-primary:hover,
    .btn-outline-danger:hover,
    .btn-outline-warning:hover {
        transform: translateY(-2px);
        transition: transform 0.2s;
    }
    
    /* Checkbox Styles */
    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    /* Search Box Styles */
    .search-box .bi-search {
        left: 1rem;
        pointer-events: none;
    }
    
    .search-box input {
        padding-left: 2.8rem !important;
    }
    
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--slate-200);
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary);
        box-shadow: 0 15px 30px rgba(40, 167, 69, 0.1);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        background: rgba(40, 167, 69, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.8rem;
        color: var(--primary);
    }
    
    .stat-label {
        color: var(--slate-500);
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
    }
    
    .stat-value {
        font-family: 'Outfit', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--slate-800);
    }
    
    /* Alert Styles */
    .alert-custom {
        border-radius: 12px;
        border: none;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Delete user modal
    document.querySelectorAll('.delete-user').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.id;
            const userName = this.dataset.name;
            
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteUserForm').action = `/admin/users/${userId}`;
            
            new bootstrap.Modal(document.getElementById('deleteUserModal')).show();
        });
    });
    
    // Toggle status
    let toggleUserId = null;
    
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            toggleUserId = this.dataset.id;
            const userName = this.dataset.name;
            const isActive = this.dataset.active === '1';
            
            const action = isActive ? 'deactivate' : 'activate';
            
            document.getElementById('toggleAction').textContent = action;
            document.getElementById('toggleUserName').textContent = userName;
            
            new bootstrap.Modal(document.getElementById('toggleStatusModal')).show();
        });
    });
    
    document.getElementById('confirmToggle').addEventListener('click', function() {
        fetch(`/admin/users/${toggleUserId}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
        
        bootstrap.Modal.getInstance(document.getElementById('toggleStatusModal')).hide();
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endpush