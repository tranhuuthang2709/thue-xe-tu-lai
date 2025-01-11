@extends('admin.index')

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Trang chủ</h3>
                <h6 class="op-7 mb-2">Thống kê tổng quan</h6>
            </div>
        </div>

        <!-- Thống kê tổng quan -->
        <div class="row">
            <!-- Số xe -->
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-car"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Số xe</p>
                                    <h4 class="card-title">{{ $totalCars }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @can('admin')
                <!-- Số người sử dụng -->
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Người sử dụng</p>
                                        <h4 class="card-title">{{ $totalUsers }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan


            <!-- Số đơn thuê -->
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-luggage-cart"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Đơn thuê</p>
                                    <h4 class="card-title">{{ $totalBookings }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tổng số đơn thanh toán thành công -->
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Đơn hủy</p>
                                    <h4 class="card-title">{{ $totalRefund }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ doanh thu theo tháng -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Doanh thu theo tháng</h4>
                    </div>
                    <form method="GET" action="{{ route('admin.home') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Từ ngày</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">Đến ngày</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Lọc doanh thu</button>
                            </div>
                        </div>
                    </form>

                    <div class="card-body">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Trạng thái đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Thêm CDN Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

    <script>
        // biểu đồ đường
        var monthlyRevenueData = @json($monthlyRevenueData);
        var ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                datasets: [{
                    label: 'Doanh thu theo tháng (VNĐ)',
                    data: monthlyRevenueData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString(); // Định dạng số
                            }
                        }
                    }
                }
            }
        });

        // Biểu đồ tròn (Pie Chart) cho trạng thái đơn hàng
        var bookingStatusCounts = @json($bookingStatusCounts);

        var ctxStatus = document.getElementById('statusChart').getContext('2d');
        var statusChart = new Chart(ctxStatus, {
            type: 'pie',
            data: {
                labels: ['Thành công', 'Đang xử lý', 'Đang lấy xe', 'Đang giao',
                    'Đơn hủy'
                ],
                datasets: [{
                    data: [
                        bookingStatusCounts['Thành công'] || 0,
                        bookingStatusCounts['Đang xử lý'] || 0,
                        bookingStatusCounts['Đang lấy xe'] || 0,
                        bookingStatusCounts['Đang giao'] || 0,
                        bookingStatusCounts['Đã hủy'] || 0
                    ], // Dữ liệu cho biểu đồ tròn
                    backgroundColor: ['#4CAF50', '#FF9800', '#2196F3', '#FFC107',
                        '#F44336'
                    ], // Màu sắc cho từng phần
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem
                                    .raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
