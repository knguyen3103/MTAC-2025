@extends('layouts.admin')

@section('content')
<style>
  .stat-card {
    border-width: 2px;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    min-height: 100px;
    transition: 0.3s ease;
    text-align: center;
    background-color: #fff;
  }
  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.05);
  }
  .stat-title {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 4px;
  }
  .stat-value {
    font-size: 1.4rem;
    font-weight: bold;
    color: #212529;
  }
</style>

<div class="container py-4">
  <h3 class="mb-4 fw-bold text-primary">
    <i class="bi bi-bar-chart-fill me-2"></i> Thống kê & Xuất báo cáo nhân sự
  </h3>

  {{-- Tổng quan --}}
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3 mb-4">
    {{-- Tổng nhân viên --}}
    <div class="col">
      <div class="stat-card border border-primary">
        <div class="stat-title">Tổng nhân viên</div>
        <div class="stat-value">{{ $total }}</div>
      </div>
    </div>

    {{-- Theo trạng thái --}}
    @foreach($byStatus as $status => $count)
      @php
        $borderColor = match($status) {
          'Chính thức'     => 'success',
          'Thử việc'       => 'warning',
          'Đào tạo'        => 'info',
          'Thực tập'       => 'primary',
          'Cộng tác viên'  => 'secondary',
          'Loại'           => 'danger',
          default          => 'dark'
        };
      @endphp
      <div class="col">
        <div class="stat-card border border-{{ $borderColor }}">
          <div class="stat-title">{{ $status }}</div>
          <div class="stat-value">{{ $count }}</div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- Biểu đồ Pie --}}
  <div class="section-box mb-5 p-4 bg-white shadow-sm rounded">
    <h5 class="fw-bold mb-3">📊 Tỷ lệ nhân sự theo phòng ban</h5>

    @if($departments->count())
      <canvas id="chartNhanVien" style="max-height: 380px;"></canvas>
    @else
      <p class="text-muted">Không có dữ liệu phòng ban để hiển thị biểu đồ.</p>
    @endif
  </div>

  {{-- Button export --}}
  <div class="text-end">
    <a href="{{ route('admin.reports.export') }}" class="btn btn-success shadow-sm">
      <i class="bi bi-file-earmark-excel-fill me-1"></i> Xuất danh sách (Excel)
    </a>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('chartNhanVien');
  if (ctx) {
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: {!! json_encode($departments->pluck('ten_phongban')) !!},
        datasets: [{
          data: {!! json_encode($departments->pluck('employees_count')) !!},
          backgroundColor: [
            '#0d6efd', '#198754', '#ffc107', '#dc3545',
            '#6f42c1', '#20c997', '#fd7e14', '#6610f2', '#adb5bd'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 20,
              padding: 15
            }
          }
        }
      }
    });
  }
</script>
@endsection
