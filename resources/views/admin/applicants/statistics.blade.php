@extends('layouts.admin')

@section('content')
<style>
    .card-stat {
        border-radius: 12px;
        padding: 20px;
        min-height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    }

    .card-stat:hover {
        transform: translateY(-3px);
    }

    .stat-title {
        font-size: 1rem;
        font-weight: 600;
        color: #444;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: bold;
        color: #000;
    }

    .chart-container {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.04);
        height: 100%;
    }

    .chart-title {
        text-align: center;
        font-weight: bold;
        color: #6c757d;
        margin-bottom: 20px;
    }

    canvas {
        max-height: 320px;
        width: 100% !important;
        height: auto !important;
        display: block;
        margin: 0 auto;
    }
</style>

<div class="container mt-4">
    <h4 class="fw-bold text-primary mb-4"><i class="fas fa-chart-bar me-2"></i>Thống kê tuyển dụng</h4>

    <div class="row g-4 text-center mb-4">
        <div class="col-md-4">
            <div class="card-stat border border-warning text-warning bg-white">
                <div>
                    <div class="stat-title">Chờ duyệt</div>
                    <div class="stat-value">{{ $pending ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-stat border border-success text-success bg-white">
                <div>
                    <div class="stat-title">Đã duyệt</div>
                    <div class="stat-value">{{ $approved ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-stat border border-danger text-danger bg-white">
                <div>
                    <div class="stat-title">Loại</div>
                    <div class="stat-value">{{ $rejected ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="chart-container">
                <div class="chart-title">📊 Biểu đồ trạng thái hồ sơ</div>
                <canvas id="statusChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container">
                <div class="chart-title">🥇 Tỷ lệ xác nhận hồ sơ</div>
                <canvas id="confirmPieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: ['Chờ duyệt', 'Đã duyệt', 'Loại'],
            datasets: [{
                label: 'Số lượng ứng viên',
                data: [{{ $pending ?? 0 }}, {{ $approved ?? 0 }}, {{ $rejected ?? 0 }}],
                backgroundColor: ['#ffc107', '#198754', '#dc3545'],
                borderColor: ['#ffca2c', '#157347', '#bb2d3b'],
                borderWidth: 1
            }]
        },
        options: {
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            },
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        stepSize: 1
                    },
                    title: {
                        display: true,
                        text: 'Số lượng'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Trạng thái'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    new Chart(document.getElementById('confirmPieChart'), {
        type: 'pie',
        data: {
            labels: ['Đã đồng ý', 'Không đồng ý', 'Khác'],
            datasets: [{
                label: 'Tỷ lệ xác nhận',
                data: [{{ $confirmed }}, {{ $unconfirmed }}, {{ $other }}],
                backgroundColor: ['#198754', '#ffc107', '#6c757d'],
                borderColor: ['#157347', '#e0a800', '#5c636a'],
                borderWidth: 1
            }]
        },
        options: {
            animation: {
                duration: 1200,
                easing: 'easeInOutCirc'
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection
