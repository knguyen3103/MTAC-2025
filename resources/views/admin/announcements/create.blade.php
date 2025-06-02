@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <style>
  .container h3 {
    font-size: 1.5rem;
    font-weight: bold;
    border-left: 6px solid #198754;
    padding-left: 12px;
    margin-bottom: 1.5rem;
  }

  .form-label {
    font-weight: 600;
  }

  .form-control, .form-select {
    font-size: 0.95rem;
    border-radius: 8px;
    padding: 10px 12px;
  }

  .btn i {
    margin-right: 6px;
  }

  .alert-danger {
    background: #ffe2e6;
    border-left: 5px solid #f1416c;
    padding: 12px 16px;
    font-size: 0.95rem;
    color: #a6122b;
    border-radius: 6px;
  }

  .alert-danger ul {
    margin-bottom: 0;
    padding-left: 18px;
  }

  .d-flex.gap-2 {
    gap: 10px;
  }
</style>
  <h3 class="mb-4">📝 Tạo thông báo mới</h3>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.announcements.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label class="form-label">Tiêu đề</label>
      <input type="text" name="tieu_de" class="form-control" required value="{{ old('tieu_de') }}">
    </div>

    <div class="mb-3">
      <label class="form-label">Nội dung</label>
      <textarea name="noi_dung" rows="6" class="form-control" required>{{ old('noi_dung') }}</textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Độ quan trọng</label>
      <select name="do_quan_trong" class="form-select" required>
        <option value="Thường" {{ old('do_quan_trong') === 'Thường' ? 'selected' : '' }}>Thường</option>
        <option value="Quan trọng" {{ old('do_quan_trong') === 'Quan trọng' ? 'selected' : '' }}>Quan trọng</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Gửi đến phòng ban</label>
      <select name="department_id" class="form-select">
        <option value="">Tất cả nhân viên</option>
        @foreach ($departments as $dept)
          <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
            {{ $dept->ten_phongban }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Hiển thị từ (tuỳ chọn)</label>
        <input type="date" name="hien_thi_tu" class="form-control" value="{{ old('hien_thi_tu') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Hiển thị đến (tuỳ chọn)</label>
        <input type="date" name="hien_thi_den" class="form-control" value="{{ old('hien_thi_den') }}">
      </div>
    </div>

    <div class="d-flex gap-2">
      <button class="btn btn-success" type="submit">
        <i class="bi bi-check-circle"></i> Lưu
      </button>
      <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Quay lại
      </a>
    </div>
  </form>
</div>
@endsection
