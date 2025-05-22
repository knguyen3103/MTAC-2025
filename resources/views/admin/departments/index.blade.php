@extends('layouts.admin')

@section('content')
<div class="container">
  <h3>Danh sách phòng ban</h3>
  <a href="{{ route('admin.departments.create') }}" class="btn btn-primary mb-3">
    <i class="bi bi-plus-circle"></i> Thêm mới
  </a>

  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Tên phòng ban</th>
        <th>Mã phòng ban</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      @forelse($departments as $d)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $d->ten_phongban }}</td>
          <td>{{ $d->ma_phongban }}</td>
          <td>
            <a href="{{ route('admin.departments.edit', $d->id) }}" class="btn btn-warning btn-sm">
              <i class="bi bi-pencil"></i> Sửa
            </a>
            <form action="{{ route('admin.departments.destroy', $d->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Xác nhận xoá phòng ban này?');">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i> Xoá
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="4" class="text-center">Chưa có phòng ban</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
