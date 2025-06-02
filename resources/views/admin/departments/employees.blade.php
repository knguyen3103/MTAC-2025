@extends('layouts.admin')

@section('content')
<!-- Bootstrap Icons (nếu chưa có) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
  .container h4 {
    font-size: 1.4rem;
    font-weight: bold;
    border-left: 6px solid #0d6efd;
    padding-left: 12px;
  }

  .table th, .table td {
    vertical-align: middle;
    text-align: center;
  }

  .badge {
    font-size: 0.85rem;
    padding: 6px 10px;
    border-radius: 12px;
  }

  .table-responsive {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }

  .btn i {
    margin-right: 6px;
  }
</style>

<div class="container py-4">
  <h4 class="mb-3">👥 Nhân sự thuộc phòng ban: <strong>{{ $department->ten_phongban }}</strong></h4>

  <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary mb-3">
    <i class="bi bi-arrow-left-circle"></i> Quay lại danh sách phòng ban
  </a>

  @if($employees->count())
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Mã NV</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Vị trí</th>
            <th>Trạng thái</th>
          </tr>
        </thead>
        <tbody>
          @foreach($employees as $nv)
            <tr>
              <td>{{ $loop->iteration + ($employees->currentPage() - 1) * $employees->perPage() }}</td>
              <td>{{ $nv->ma_nhanvien }}</td>
              <td>{{ $nv->ho_ten }}</td>
              <td>{{ $nv->gioi_tinh }}</td>
              <td>{{ $nv->vi_tri }}</td>
              <td>
                @php 
                  $badgeColors = [
                      'Chính thức' => 'success',
                      'Thử việc' => 'warning',
                      'Học việc' => 'info',
                      'Đào tạo' => 'info',
                      'Thực tập' => 'primary',
                      'Cộng tác viên' => 'secondary',
                      'Thời vụ' => 'dark',
                      'Tạm hoãn HĐLĐ' => 'light',
                      'Nghỉ việc' => 'danger',
                      'Nghỉ thai sản' => 'purple'
                  ];
                  $color = $badgeColors[$nv->trang_thai] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $color == 'purple' ? 'secondary' : $color }}">
                  {{ $nv->trang_thai }}
                </span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
      {{ $employees->links() }}
    </div>
  @else
    <div class="alert alert-warning text-center mt-4">
      <i class="bi bi-exclamation-circle"></i> Không có nhân viên nào trong phòng ban này.
    </div>
  @endif
</div>
@endsection
