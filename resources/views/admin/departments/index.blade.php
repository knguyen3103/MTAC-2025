@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
  .table th, .table td {
    vertical-align: middle;
    text-align: center;
  }

  .btn-sm i {
    margin-right: 4px;
  }

  .container h3 {
    font-size: 1.5rem;
    font-weight: bold;
    border-left: 6px solid #0d6efd;
    padding-left: 12px;
    margin-bottom: 1.5rem;
  }

  .table-responsive {
    border-radius: 8px;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
  }
</style>

<div class="container py-4">
  <h3>🏢 Danh sách phòng ban</h3>

  <a href="{{ route('admin.departments.create') }}" class="btn btn-primary mb-3">
    <i class="bi bi-plus-circle"></i> Thêm phòng ban mới
  </a>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
    </div>
  @endif

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Tên phòng ban</th>
          <th>Mã phòng ban</th>
          <th>Nhân sự</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        @forelse($departments as $d)
          <tr>
            <td>{{ $loop->iteration + ($departments->currentPage() - 1) * $departments->perPage() }}</td>
            <td>{{ $d->ten_phongban }}</td>
            <td>{{ $d->ma_phongban }}</td>
            <td>
              <a href="{{ route('admin.departments.employees', $d->id) }}" class="btn btn-sm btn-outline-info">
                <i class="bi bi-people-fill"></i> Xem ({{ $d->employees_count }})
              </a>
            </td>
            <td>
              <a href="{{ route('admin.departments.edit', $d->id) }}" class="btn btn-sm btn-warning me-1">
                <i class="bi bi-pencil"></i> Sửa
              </a>
              <form action="{{ route('admin.departments.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận xoá phòng ban này?');">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">
                  <i class="bi bi-trash"></i> Xoá
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted">Chưa có phòng ban nào.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Phân trang --}}
  <div class="d-flex justify-content-end mt-3">
    {{ $departments->links() }}
  </div>
</div>
@endsection
