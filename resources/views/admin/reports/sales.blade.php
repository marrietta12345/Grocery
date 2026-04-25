@extends('admin.layouts.admin')

@section('title', 'Sales Report - Grocery Mart Admin')
@section('page-title', 'Sales Report')

@section('content')
<div class="container-fluid">
    <!-- Date Range Filter -->
    <div class="content-card mb-4">
        <div class="card-header">
            <h3><i class="bi bi-funnel me-2" style="color: var(--primary);"></i>Filter Sales Report</h3>
        </div>
        <form method="GET" action="{{ route('admin.reports.sales') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label small mb-1">Date From</label>
                <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">Date To</label>
                <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Group By</label>
                <select name="group_by" class="form-select">
                    <option value="day" {{ $groupBy == 'day' ? 'selected' : '' }}>Daily</option>
                    <option value="week" {{ $groupBy == 'week' ? 'selected' : '' }}>Weekly</option>
                    <option value="month" {{ $groupBy == 'month' ? 'selected' : '' }}>Monthly</option>
                    <option value="year" {{ $groupBy == 'year' ? 'selected' : '' }}>Yearly</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">&nbsp;</label>
                <button type="submit" class="btn-primary-custom w-100">
                    <i class="bi bi-search"></i> Apply Filter
                </button>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">&nbsp;</label>
                <a href="{{ route('admin.reports.sales.export') }}?{{ http_build_query(request()->query()) }}" 
                   class="btn-outline-custom w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-download me-2"></i> Export Report
                </a>
            </div>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-receipt"></i>
            </div>
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">{{ number_format($summary['total_orders']) }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₱{{ number_format($summary['total_revenue'], 2) }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-calculator"></i>
            </div>
            <div class="stat-label">Average Order</div>
            <div class="stat-value">₱{{ number_format($summary['average_order'], 2) }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-label">Unique Customers</div>
            <div class="stat-value">{{ number_format($summary['total_customers']) }}</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4">
        <!-- Sales Chart -->
        <div class="col-xl-8">
            <div class="content-card h-100">
                <div class="card-header">
                    <h3><i class="bi bi-graph-up me-2" style="color: var(--primary);"></i>Sales Trend</h3>
                </div>
                <div style="position: relative; height: 400px; width: 100%;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Orders by Status -->
        <div class="col-xl-4">
            <div class="content-card h-100">
                <div class="card-header">
                    <h3><i class="bi bi-pie-chart me-2" style="color: var(--primary);"></i>Orders by Status</h3>
                </div>
                <div style="position: relative; height: 280px; width: 100%;">
                    <canvas id="statusChart"></canvas>
                </div>
                <div class="mt-3">
                    @foreach($ordersByStatus as $status => $count)
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded" style="background: var(--slate-50);">
                            <span>
                                <span class="badge bg-{{ 
                                    $status == 'completed' ? 'success' : 
                                    ($status == 'pending' ? 'warning' : 
                                    ($status == 'processing' ? 'info' : 'danger')) 
                                }} px-3 py-2">{{ ucfirst($status) }}</span>
                            </span>
                            <span class="fw-600">{{ number_format($count) }} orders</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row of Charts -->
    <div class="row g-4 mt-2">
        <!-- Orders by Payment Method -->
        <div class="col-md-6">
            <div class="content-card h-100">
                <div class="card-header">
                    <h3><i class="bi bi-credit-card me-2" style="color: var(--primary);"></i>Payment Methods</h3>
                </div>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Top Selling Products -->
        <div class="col-md-6">
            <div class="content-card h-100">
                <div class="card-header">
                    <h3><i class="bi bi-trophy me-2" style="color: var(--primary);"></i>Top Selling Products</h3>
                </div>
                <div class="table-responsive" style="max-height: 350px;">
                    <table class="table table-hover">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Product</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-img-thumb me-2" style="width: 40px; height: 40px;">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <i class="bi bi-box text-muted"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-600">{{ Str::limit($product->name, 30) }}</div>
                                            <small class="text-muted">ID: #{{ $product->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">{{ number_format($product->total_quantity) }}</td>
                                <td class="text-end fw-600">₱{{ number_format($product->total_revenue, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Data Table -->
    <div class="content-card mt-4">
        <div class="card-header">
            <h3><i class="bi bi-table me-2" style="color: var(--primary);"></i>Sales Data</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        @if($groupBy == 'day')
                            <th>Date</th>
                        @elseif($groupBy == 'week')
                            <th>Week</th>
                        @elseif($groupBy == 'month')
                            <th>Month</th>
                        @else
                            <th>Year</th>
                        @endif
                        <th class="text-end">Orders</th>
                        <th class="text-end">Total Sales</th>
                        <th class="text-end">Average Order</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesDataFormatted as $data)
                    <tr>
                        <td class="fw-600">
                            @if($groupBy == 'day')
                                {{ \Carbon\Carbon::parse($data->date)->format('M d, Y') }}
                            @elseif($groupBy == 'week')
                                Week {{ $data->week }}, {{ $data->year }}
                            @elseif($groupBy == 'month')
                                {{ \Carbon\Carbon::create()->month($data->month)->format('F') }} {{ $data->year }}
                            @else
                                {{ $data->year }}
                            @endif
                        </td>
                        <td class="text-end">{{ number_format($data->order_count) }}</td>
                        <td class="text-end fw-600">₱{{ number_format($data->total_sales, 2) }}</td>
                        <td class="text-end">₱{{ number_format($data->average_order, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="mt-2 text-muted">No sales data found for the selected period.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Total Sales (₱)',
                    data: {!! json_encode($salesDataFormatted->pluck('total_sales')) !!},
                    borderColor: 'rgb(40, 167, 69)',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgb(40, 167, 69)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Order Count',
                    data: {!! json_encode($salesDataFormatted->pluck('order_count')) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 10,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.raw;
                                if (label.includes('Sales')) {
                                    return label + ': ₱' + value.toLocaleString();
                                }
                                return label + ': ' + value.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Total Sales (₱)',
                            font: {
                                weight: 'bold',
                                size: 12
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Order Count',
                            font: {
                                weight: 'bold',
                                size: 12
                            }
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: @if($groupBy == 'day') 'Date' @elseif($groupBy == 'week') 'Week' @elseif($groupBy == 'month') 'Month' @else 'Year' @endif,
                            font: {
                                weight: 'bold',
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
        
        // Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($ordersByStatus->toArray())) !!},
                datasets: [{
                    data: {!! json_encode(array_values($ordersByStatus->toArray())) !!},
                    backgroundColor: [
                        'rgb(40, 167, 69)',
                        'rgb(245, 158, 11)',
                        'rgb(59, 130, 246)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 11
                            },
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} orders (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
        
        // Payment Methods Chart
        @if($ordersByPayment->count() > 0)
        const paymentCtx = document.getElementById('paymentChart').getContext('2d');
        const paymentLabels = {!! json_encode($ordersByPayment->pluck('payment_method')->map(function($method) {
            switch($method) {
                case 'cod': return 'Cash on Delivery';
                case 'gcash': return 'GCash';
                case 'paymaya': return 'PayMaya';
                default: return ucfirst($method);
            }
        })) !!};
        const paymentData = {!! json_encode($ordersByPayment->pluck('total')) !!};
        
        new Chart(paymentCtx, {
            type: 'bar',
            data: {
                labels: paymentLabels,
                datasets: [{
                    label: 'Total Revenue (₱)',
                    data: paymentData,
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgb(40, 167, 69)',
                    borderWidth: 1,
                    borderRadius: 8,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Revenue (₱)',
                            font: {
                                weight: 'bold',
                                size: 12
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Payment Method',
                            font: {
                                weight: 'bold',
                                size: 12
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        @endif
    });
</script>
@endpush

@push('styles')
<style>
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
    
    .content-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
        border: 1px solid var(--slate-200);
        margin-bottom: 1.5rem;
    }
    
    .content-card.h-100 {
        margin-bottom: 0;
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--slate-200);
    }
    
    .card-header h3 {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        margin: 0;
        font-size: 1.2rem;
    }
    
    .btn-primary-custom {
        background: var(--dark);
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-primary-custom:hover {
        background: var(--primary);
        transform: translateY(-2px);
        color: white;
    }
    
    .btn-outline-custom {
        background: white;
        border: 1px solid var(--slate-200);
        color: var(--slate-600);
        padding: 0.6rem 1.2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-outline-custom:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .product-img-thumb {
        width: 40px;
        height: 40px;
        background: var(--slate-100);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .product-img-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    
    .table-responsive {
        border-radius: 12px;
    }
    
    .table th {
        font-weight: 600;
        color: var(--slate-700);
        border-bottom-width: 2px;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    
    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .stat-value {
            font-size: 1.5rem;
        }
        
        .content-card {
            padding: 1rem;
        }
        
        .btn-primary-custom,
        .btn-outline-custom {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
@endpush