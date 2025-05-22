@extends('layouts.admin')

@section('content')
<div class="container">
  <h3 class="mb-4">Thêm mới nhân sự</h3>

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

    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Mã nhân viên</label>
        <input type="text" name="ma_nhanvien" class="form-control" value="{{ old('ma_nhanvien') }}" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Họ và tên</label>
        <input type="text" name="ho_ten" class="form-control" value="{{ old('ho_ten') }}" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Giới tính</label>
        <select name="gioi_tinh" class="form-select">
          <option value="Nam" {{ old('gioi_tinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
          <option value="Nữ" {{ old('gioi_tinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
          <option value="Khác" {{ old('gioi_tinh') == 'Khác' ? 'selected' : '' }}>Khác</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Ngày sinh</label>
        <input type="date" name="ngay_sinh" class="form-control" value="{{ old('ngay_sinh') }}">
      </div>
      <div class="col-md-4">
        <label class="form-label">Phòng ban</label>
        <select name="department_id" class="form-select" required>
          <option value="">-- Chọn phòng ban --</option>
          @foreach ($departments as $dept)
            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
              {{ $dept->ten_phongban }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-md-6">
        <label class="form-label">Vị trí</label>
        <input type="text" name="vi_tri" class="form-control" value="{{ old('vi_tri') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Trạng thái</label>
        <select name="trang_thai" class="form-select" required>
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
      <a href="{{ route('admin.a_employees.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>
  </form>
</div>
@endsection
