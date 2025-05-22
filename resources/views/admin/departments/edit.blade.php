@extends('layouts.admin')

@section('content')
<div class="container">
  <h3>Chỉnh sửa phòng ban</h3>
  <form action="{{ route('admin.departments.update', $department->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="ten_phongban" class="form-label">Tên phòng ban</label>
      <input type="text" name="ten_phongban" class="form-control" value="{{ old('ten_phongban', $department->ten_phongban) }}" required>
    </div>

    <div class="mb-3">
      <label for="ma_phongban" class="form-label">Mã phòng ban</label>
      <input type="text" name="ma_phongban" class="form-control" value="{{ old('ma_phongban', $department->ma_phongban) }}" required>
    </div>

    <button type="submit" class="btn btn-primary">
      <i class="bi bi-check-circle"></i> Cập nhật
    </button>
    <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">Quay lại</a>
  </form>
</div>
@endsection
