@extends('layouts.admin')

@section('content')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
  .form-label {
    font-weight: 600;
  }

  .table th, .table td {
    vertical-align: middle;
    text-align: center;
  }

  .table-responsive {
    border-radius: 10px;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
  }

  .btn-sm i {
    margin-right: 4px;
  }

  .btn-sm {
    padding: 6px 10px;
    font-size: 0.85rem;
    border-radius: 6px;
  }

  .container h3 {
    font-size: 1.5rem;
    font-weight: bold;
    border-left: 6px solid #0d6efd;
    padding-left: 12px;
    margin-bottom: 1.5rem;
  }

  .select2-container .select2-selection--single {
    height: 38px !important;
    padding: 6px 12px;
  }

  .badge-purple {
    background-color: #6f42c1;
    color: #fff;
  }
</style>

<div class="container py-4">
  <h3>📋 Danh sách nhân sự</h3>

  {{-- Bộ lọc --}}
  <div class="row align-items-end justify-content-between mb-4">
    <div class="col-md-8">
      <form action="{{ route('admin.a_employees.index') }}" method="GET" class="row gx-2 gy-2 align-items-center">
        <div class="col-auto">
          <label for="loai" class="form-label mb-0">🔍 Loại:</label>
        </div>
        <div class="col-auto">
          <select name="loai" id="loai" class="form-select">
            <option value="">Tất cả nhân sự</option>
            <option value="noi_bo" {{ request('loai') == 'noi_bo' ? 'selected' : '' }}>Nội bộ</option>
            <option value="ben_ngoai" {{ request('loai') == 'ben_ngoai' ? 'selected' : '' }}>Bên ngoài</option>
          </select>
        </div>

        <div class="col-auto">
          <label for="trang_thai" class="form-label mb-0">📂 Trạng thái:</label>
        </div>
        <div class="col-auto">
          <select name="trang_thai" id="trang_thai" class="form-select">
            <option value="">Tất cả</option>
            @foreach([
              'Chính thức', 'Thử việc', 'Học việc', 'Đào tạo',
              'Thực tập', 'Cộng tác viên', 'Thời vụ',
              'Tạm hoãn HĐLĐ', 'Nghỉ việc', 'Nghỉ thai sản'
            ] as $tt)
              <option value="{{ $tt }}" {{ request('trang_thai') == $tt ? 'selected' : '' }}>{{ $tt }}</option>
            @endforeach
          </select>
        </div>

        <div class="col">
          <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="🔎 Tên hoặc mã NV...">
        </div>

        <div class="col-auto">
          <button type="submit" class="btn btn-outline-primary">
            <i class="bi bi-search"></i> Tìm
          </button>
        </div>
      </form>
    </div>

    <div class="col-auto d-flex gap-2">
      <a href="{{ route('admin.a_employees.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm mới
      </a>
      <a href="{{ route('admin.applicants.new_employees') }}" class="btn btn-outline-success"><i class="bi bi-person-check"></i> Nhân viên mới</a>
    </div>
  </div>

  {{-- Thông báo --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
    </div>
  @endif

  {{-- Danh sách --}}
  @if($employees->count())
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Mã NV</th>
          <th>Họ tên</th>
          <th>Giới tính</th>
          <th>Phòng ban</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        @foreach($employees as $nv)
        <tr>
          <td>{{ $loop->iteration + ($employees->currentPage() - 1) * $employees->perPage() }}</td>
          <td>{{ $nv->ma_nhanvien }}</td>
          <td>{{ $nv->ho_ten }}</td>
          <td>{{ $nv->gioi_tinh }}</td>
          <td>{{ $nv->department->ten_phongban ?? '-' }}</td>
          <td>
            @php
              $colorMap = [
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
              $color = $colorMap[$nv->trang_thai] ?? 'secondary';
            @endphp
            <span class="badge {{ $color == 'purple' ? 'badge-purple' : 'bg-' . $color }}">
              {{ $nv->trang_thai }}
            </span>
          </td>
          <td>
            <a href="{{ route('admin.a_employees.show', $nv->id) }}" class="btn btn-sm btn-info me-1">
              <i class="bi bi-eye"></i> Xem
            </a>
            <a href="{{ route('admin.a_employees.edit', $nv->id) }}" class="btn btn-sm btn-warning me-1">
              <i class="bi bi-pencil"></i> Sửa
            </a>
            <form action="{{ route('admin.a_employees.destroy', $nv->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận xoá?');">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i> Xoá
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- Phân trang --}}
  <div class="d-flex justify-content-end mt-3">
    {{ $employees->links() }}
  </div>

  @else
    <div class="alert alert-warning text-center mt-4">
      <i class="bi bi-exclamation-circle"></i> Không tìm thấy nhân sự nào phù hợp.
    </div>
  @endif
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    $('#loai').select2({ placeholder: "Chọn loại nhân sự", width: 'resolve' });
    $('#trang_thai').select2({ placeholder: "Chọn trạng thái", width: 'resolve' });
  });
</script>
@endsection
