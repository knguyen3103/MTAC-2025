@extends('layouts.admin')

@section('content')
<div class="container">
  <h3 class="mb-3">Danh sách nhân sự</h3>

  {{-- Bộ lọc + tìm kiếm + thêm mới --}}
  <div class="row align-items-end justify-content-between mb-4">
    <div class="col-md-8">
      <form action="{{ route('admin.a_employees.index') }}" method="GET" class="row gx-2 gy-2 align-items-center">
        <div class="col-auto">
          <label for="loai" class="form-label fw-bold mb-0">Lọc theo loại:</label>
        </div>
        <div class="col-auto">
          <select name="loai" id="loai" onchange="this.form.submit()" class="form-select">
            <option value="">Tất cả nhân sự</option>
            <option value="noi_bo" {{ request('loai') == 'noi_bo' ? 'selected' : '' }}>Nội bộ</option>
            <option value="ben_ngoai" {{ request('loai') == 'ben_ngoai' ? 'selected' : '' }}>Bên ngoài</option>
          </select>
        </div>
        <div class="col-auto">
          <label for="trang_thai" class="form-label fw-bold mb-0">Trạng thái:</label>
        </div>
        <div class="col-auto">
          <select name="trang_thai" id="trang_thai" onchange="this.form.submit()" class="form-select">
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
          <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Tìm theo tên / mã NV...">
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-outline-primary">
            <i class="bi bi-search"></i> Tìm kiếm
          </button>
        </div>
      </form>
    </div>

    <div class="col-auto">
      <a href="{{ route('admin.a_employees.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm mới
      </a>
    </div>
  </div>

  {{-- Thông báo --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Danh sách nhân viên --}}
  @if($employees->count())
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light text-center">
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
          <td class="text-center">{{ $loop->iteration + ($employees->currentPage() - 1) * $employees->perPage() }}</td>
          <td>{{ $nv->ma_nhanvien }}</td>
          <td>{{ $nv->ho_ten }}</td>
          <td>{{ $nv->gioi_tinh }}</td>
          <td>{{ $nv->department->ten_phongban ?? '-' }}</td>
          <td>{{ $nv->trang_thai }}</td>
          <td class="text-center">
             <a href="{{ route('admin.a_employees.show', $nv->id) }}" class="btn btn-sm btn-info me-1">
              <i class="bi bi-eye"></i> Xem
            </a>
            <a href="{{ route('admin.a_employees.edit', $nv->id) }}" class="btn btn-sm btn-warning me-1">
              <i class="bi bi-pencil"></i> Sửa
            </a>
            <form action="{{ route('admin.a_employees.destroy', $nv->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Xác nhận xoá?');">
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
    <div class="alert alert-warning text-center">
      Không tìm thấy nhân sự nào phù hợp.
    </div>
  @endif
</div>
@endsection