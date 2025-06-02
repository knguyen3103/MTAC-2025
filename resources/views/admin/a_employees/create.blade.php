@extends('layouts.admin')

@section('content')
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
  .form-label {
    font-weight: 600;
  }

  .form-select, .form-control {
    font-size: 0.95rem;
    border-radius: 8px;
    padding: 10px 12px;
  }

  .btn i {
    margin-right: 6px;
  }

  .container h3 {
    font-size: 1.5rem;
    font-weight: bold;
    border-left: 6px solid #198754;
    padding-left: 12px;
    margin-bottom: 1.5rem;
  }

  .alert ul {
    margin-bottom: 0;
    padding-left: 18px;
  }

  .select2-container .select2-selection--single {
    height: 38px !important;
    padding: 6px 12px;
  }
</style>

<div class="container py-4">
  <h3>➕ Thêm mới nhân sự</h3>

  {{-- Hiển thị lỗi --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Vui lòng kiểm tra lại:</strong>
      <ul class="mb-0">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.a_employees.store') }}" method="POST">
    @csrf

    {{-- Mã nhân viên sẽ được sinh tự động --}}
    <input type="hidden" name="ma_nhanvien" value="AUTO" />

    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Họ và tên</label>
        <input type="text" name="ho_ten" class="form-control" value="{{ old('ho_ten') }}" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Giới tính</label>
        <select name="gioi_tinh" class="form-select">
          <option value="Nam" {{ old('gioi_tinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
          <option value="Nữ" {{ old('gioi_tinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
          <option value="Khác" {{ old('gioi_tinh') == 'Khác' ? 'selected' : '' }}>Khác</option>
        </select>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Ngày sinh</label>
        <input type="date" name="ngay_sinh" class="form-control" value="{{ old('ngay_sinh') }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Phòng ban</label>
        <select name="department_id" class="form-select select2" required>
          <option value="">-- Chọn phòng ban --</option>
          @foreach ($departments as $dept)
            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
              {{ $dept->ten_phongban }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Vị trí</label>
        <input type="text" name="vi_tri" class="form-control" value="{{ old('vi_tri') }}">
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-md-6">
        <label class="form-label">Trạng thái</label>
        <select name="trang_thai" class="form-select select2" required>
          @foreach(['Chính thức', 'Thử việc', 'Học việc', 'Đào tạo', 'Thực tập', 'Cộng tác viên', 'Thời vụ', 'Tạm hoãn HĐLĐ', 'Nghỉ việc', 'Nghỉ thai sản'] as $tt)
            <option value="{{ $tt }}" {{ old('trang_thai') == $tt ? 'selected' : '' }}>{{ $tt }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="d-flex gap-3">
      <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> Lưu
      </button>
      <a href="{{ route('admin.a_employees.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Quay lại
      </a>
    </div>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2({
      width: 'resolve',
      placeholder: 'Chọn'
    });
  });
</script>
@endsection
