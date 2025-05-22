@extends('layouts.admin')

@section('content')
<div class="container">
  <h3 class="mb-4">Thông tin chi tiết nhân sự</h3>

  {{-- Thông tin cơ bản --}}
  <div class="card mb-4 shadow-sm">
    <div class="card-header fw-bold bg-primary text-white">Thông tin cơ bản</div>
    <div class="card-body row">
      <div class="col-md-6"><p><strong>Mã nhân viên:</strong> {{ $employee->ma_nhanvien }}</p></div>
      <div class="col-md-6"><p><strong>Họ và tên:</strong> {{ $employee->ho_ten }}</p></div>
      <div class="col-md-6"><p><strong>Giới tính:</strong> {{ $employee->gioi_tinh }}</p></div>
      <div class="col-md-6"><p><strong>Ngày sinh:</strong> {{ $employee->ngay_sinh }}</p></div>
      <div class="col-md-6"><p><strong>Email:</strong> {{ $employee->email }}</p></div>
      <div class="col-md-6"><p><strong>Số điện thoại:</strong> {{ $employee->so_dien_thoai }}</p></div>
      <div class="col-md-6"><p><strong>Phòng ban:</strong> {{ $employee->department->ten_phongban ?? '-' }}</p></div>
      <div class="col-md-6"><p><strong>Vị trí:</strong> {{ $employee->vi_tri }}</p></div>
      <div class="col-md-6"><p><strong>Chức vụ:</strong> {{ $employee->chuc_vu }}</p></div>
      <div class="col-md-6"><p><strong>Trạng thái:</strong> {{ $employee->trang_thai }}</p></div>
    </div>
  </div>

  {{-- Thông tin công việc --}}
  <div class="card mb-4 shadow-sm">
    <div class="card-header fw-bold bg-success text-white">Thông tin công việc</div>
    <div class="card-body row">
      <div class="col-md-6"><p><strong>Mã chấm công:</strong> {{ $employee->ma_cham_cong }}</p></div>
      <div class="col-md-6"><p><strong>Ngày vào thử việc:</strong> {{ $employee->ngay_vao_thu_viec }}</p></div>
      <div class="col-md-6"><p><strong>Ngày kết thúc thử việc:</strong> {{ $employee->ngay_ket_thuc_thu_viec }}</p></div>
      <div class="col-md-6"><p><strong>Kết quả thử việc:</strong> {{ $employee->ket_qua_thu_viec }}</p></div>
      <div class="col-md-6"><p><strong>Ngày vào học việc:</strong> {{ $employee->ngay_vao_hoc_viec }}</p></div>
      <div class="col-md-6"><p><strong>Ngày kết thúc học việc:</strong> {{ $employee->ngay_ket_thuc_hoc_viec }}</p></div>
      <div class="col-md-6"><p><strong>Kết quả học việc:</strong> {{ $employee->ket_qua_hoc_viec }}</p></div>
      <div class="col-md-6"><p><strong>Ngày vào chính thức:</strong> {{ $employee->ngay_vao_chinh_thuc }}</p></div>
    </div>
  </div>

  {{-- Thông tin thực tập --}}
  <div class="card mb-4 shadow-sm">
    <div class="card-header fw-bold bg-info text-white">Thông tin thực tập</div>
    <div class="card-body row">
      <div class="col-md-6"><p><strong>Ngày thực tập:</strong> {{ $employee->ngay_thuc_tap }}</p></div>
      <div class="col-md-6"><p><strong>Ngày kết thúc thực tập:</strong> {{ $employee->ngay_ket_thuc_thuc_tap }}</p></div>
      <div class="col-md-6"><p><strong>Đề tài thực tập:</strong> {{ $employee->de_tai_thuc_tap }}</p></div>
      <div class="col-md-6"><p><strong>Đánh giá thực tập:</strong> {{ $employee->danh_gia_thuc_tap }}</p></div>
    </div>
  </div>

  {{-- Nút hành động --}}
  <div class="d-flex justify-content-end gap-3">
    <a href="{{ route('admin.a_employees.index') }}" class="btn btn-secondary">
      <i class="bi bi-arrow-left-circle"></i> Quay lại
    </a>
    <a href="{{ route('admin.a_employees.edit', $employee->id) }}" class="btn btn-warning">
      <i class="bi bi-pencil-square"></i> Chỉnh sửa
    </a>
  </div>
</div>
@endsection
