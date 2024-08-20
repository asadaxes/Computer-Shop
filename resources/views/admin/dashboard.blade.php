@extends("admin_base")
@section("title") Dashboard @endsection
@section("style")
<style>
.avatar_img{
    width: 25px;
    height: 25px;
    border-radius: 50%;   
}
</style>
@endsection
@section("content")
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Users</span>
                        <span class="info-box-number">{{ $total_users }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-boxes-stacked"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Products</span>
                        <span class="info-box-number">{{ $total_products }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-clipboard-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Active Orders</span>
                        <span class="info-box-number">{{ $incomplete_orders }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-b"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Brands</span>
                        <span class="info-box-number">{{ $total_brands }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-sitemap"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Categories</span>
                        <span class="info-box-number">{{ $total_category }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-table-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Sub-Categories</span>
                        <span class="info-box-number">{{ $total_sub_category }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-ticket"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Coupons</span>
                        <span class="info-box-number">{{ $total_coupons }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-bolt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Flash Sale Items</span>
                        <span class="info-box-number">{{ $total_flash_sale }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-tags"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Best Deals Items</span>
                        <span class="info-box-number">{{ $total_best_deals }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-thumbs-up"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Recommended</span>
                        <span class="info-box-number">{{ $total_recommends }}</span>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="card card-body">
            <span class="text-muted text-center">Orders by Payment Method</span>
            <div>
                <canvas id="paymentMethodChart" width="400"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-body">
            <span class="text-muted text-center">Monthly Orders</span>
            <canvas id="monthlyOrderChart" height="400"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-body">
            <span class="text-muted text-center">Monthly Revenue</span>
            <canvas id="monthlyRevenueChart" height="400"></canvas>
        </div>
    </div>
</div>

<div class="row">
<div class="col-12">
    <small class="text-muted"><i class="fa-solid fa-landmark"></i> Recent Payments</small>
    <table class="table table-striped bg-white text-center">
        <thead>
            <tr>
                <th>User</th>
                <th><i class="fa-solid fa-bangladeshi-taka-sign"></i> Amount</th>
                <th>Order ID</th>
                <th>Transaction ID</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recent_payments as $payment)
                <tr>
                    <td>
                        <a href="{{ route('admin_users_view', ['uid' => $payment->user->id]) }}" class="text-dark"><img src="{{ Storage::url($payment->user->avatar) }}" class="img-fluid avatar_img">
                        {{ $payment->user->full_name }}</a>
                    </td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->order_id }}</td>
                    <td>{{ $payment->tran_id }}</td>
                    <td>
                        @if ($payment->status == 'Pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif ($payment->status == 'Failed')
                            <span class="badge badge-danger">Failed</span>
                        @elseif ($payment->status == 'Cancel')
                            <span class="badge badge-secondary">Cancelled</span>
                        @elseif ($payment->status == 'Complete' || $payment->status == 'Processing')
                            <span class="badge badge-success">{{ ucfirst($payment->status) }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">no payments!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
@section("script")
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentsByDay = @json($paymentsByDay);
    const ordersByDay = @json($ordersByDay);
    const labels = Array.from({ length: paymentsByDay.length }, (_, index) => (index + 1).toString());

    new Chart(document.getElementById('monthlyOrderChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Orders',
                data: ordersByDay,
                borderColor: '#f79f1f',
                backgroundColor: '#f79f1f',
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    new Chart(document.getElementById('monthlyRevenueChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue',
                data: paymentsByDay,
                borderColor: '#28a745d1',
                backgroundColor: '#28a745d1',
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    new Chart(document.getElementById('paymentMethodChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Digital Payments', 'Cash on Delivery'],
            datasets: [{
                data: [{{ $payWithSslCount }}, {{ $cashOnDeliveryCount }}],
                backgroundColor: ['#36A2EB', '#FF6384']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
});
</script>
@endsection