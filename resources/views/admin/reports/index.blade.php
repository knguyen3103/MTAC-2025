@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <h3 class="mb-4 fw-bold text-primary">
    <i class="bi bi-bar-chart-fill me-2"></i>Xuất Report & Thống kê
  </h3>

  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card text-white bg-info mb-3">
        <div class="card-body">
          <h5 class="card-title">Tổng nhân viên</h5>
          <p class="card-text fs-4 fw-bold">{{ $total }}</p>
        </div>
      </div>
    </div>
    @foreach($byStatus as $status => $count)
    <div class="col-md-3">
      <div class="card bg-light border mb-3">
        <div class="card-body">
          <h6 class="card-title">{{ $status }}</h6>
          <p class="card-text fw-semibold fs-5">{{ $count }}</p>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="mb-4">
    <h5 class="fw-bold">Tỷ lệ nhân sự theo phòng ban</h5>
    <canvas id="chartNhanVien" style="height: 350px;"></canvas>
  </div>

  <a href="{{ route('admin.reports.export') }}" class="btn btn-success">
    <i class="bi bi-file-earmark-excel"></i> Tải danh sách nhân viên (Excel)
  </a>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('chartNhanVien');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: {!! json_encode($departments->pluck('ten_phongban')) !!},
      datasets: [{
        label: 'Số lượng',
        data: {!! json_encode($departments->pluck('employees_count')) !!},
        backgroundColor: [
          '#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1', '#20c997', '#fd7e14'
        ],
        borderWidth: 1
      }]
    },
    options: {
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
