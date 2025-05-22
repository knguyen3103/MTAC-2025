@extends('layouts.admin')

@section('content')
<div class="container">
  <h3 class="mb-4">Chỉnh sửa nhân viên</h3>

  {{-- Thông báo --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('admin.a_employees.update', $employee->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Mã nhân viên <span class="text-danger">*</span></label>
        <input type="text" name="ma_nhanvien" class="form-control" value="{{ old('ma_nhanvien', $employee->ma_nhanvien) }}" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Mã chấm công</label>
        <input type="text" name="ma_cham_cong" class="form-control" value="{{ old('ma_cham_cong', $employee->ma_cham_cong) }}">
      </div>

      <div class="col-md-6">
        <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
        <input type="text" name="ho_ten" class="form-control" value="{{ old('ho_ten', $employee->ho_ten) }}" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Giới tính</label>
        <select name="gioi_tinh" class="form-select">
          <option value="Nam" {{ old('gioi_tinh', $employee->gioi_tinh) == 'Nam' ? 'selected' : '' }}>Nam</option>
          <option value="Nữ" {{ old('gioi_tinh', $employee->gioi_tinh) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
          <option value="Khác" {{ old('gioi_tinh', $employee->gioi_tinh) == 'Khác' ? 'selected' : '' }}>Khác</option>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Ngày sinh</label>
        <input type="date" name="ngay_sinh" class="form-control" value="{{ old('ngay_sinh', $employee->ngay_sinh) }}">
      </div>

      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}">
      </div>

      <div class="col-md-6">
        <label class="form-label">Số điện thoại</label>
        <input type="text" name="so_dien_thoai" class="form-control" value="{{ old('so_dien_thoai', $employee->so_dien_thoai) }}">
      </div>

      <div class="col-md-6">
        <label class="form-label">Phòng ban</label>
        <select name="department_id" class="form-select">
          @foreach($departments as $dept)
            <option value="{{ $dept->id }}" {{ $employee->department_id == $dept->id ? 'selected' : '' }}>
              {{ $dept->ten_phongban }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Vị trí</label>
        <input type="text" name="vi_tri" class="form-control" value="{{ old('vi_tri', $employee->vi_tri) }}">
      </div>

      <div class="col-md-6">
        <label class="form-label">Chức vụ</label>
        <input type="text" name="chuc_vu" class="form-control" value="{{ old('chuc_vu', $employee->chuc_vu) }}">
      </div>

      <div class="col-md-6">
        <label class="form-label">Trạng thái</label>
        <select name="trang_thai" class="form-select">
          @foreach([
            'Chính thức', 'Thử việc', 'Học việc', 'Đào tạo',
            'Thực tập', 'Cộng tác viên', 'Thời vụ',
            'Tạm hoãn HĐLĐ', 'Nghỉ việc', 'Nghỉ thai sản'
          ] as $tt)
            <option value="{{ $tt }}" {{ old('trang_thai', $employee->trang_thai) == $tt ? 'selected' : '' }}>
              {{ $tt }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="d-flex justify-content-end mt-4 gap-3">
      <button class="btn btn-primary" type="submit">
        <i class="bi bi-save"></i> Cập nhật
      </button>
      <a href="{{ route('admin.a_employees.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Quay lại
      </a>
    </div>
  </form>
</div>
@endsection
