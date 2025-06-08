@extends('layouts.employee')

@section('content')
<style>
  .card.text-center {
    transition: 0.3s ease;
  }
  .card.text-center:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  }
  .card .fs-3 {
    font-size: 1.8rem !important;
  }
  .card .btn {
    font-weight: 500;
    font-size: 0.85rem;
  }
  .badge-announcement {
    position: absolute;
    top: 10px;
    right: 14px;
    background-color: #dc3545;
    color: #fff;
    font-size: 0.65rem;
    padding: 0.25em 0.5em;
    border-radius: 10px;
    font-weight: 600;
  }
</style>

<div class="container mt-4">
  <h3 class="mb-4 fw-bold text-primary">
    <i class="bi bi-speedometer2 me-2"></i> Trang chủ nhân viên
  </h3>

  <div class="row g-3 mb-5">

    <!-- Bản tin nội bộ -->
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card shadow-sm border-0 text-center h-100 position-relative">
        @php
          $badgeCount = $announcementCount >= 30 ? 0 : $announcementCount;
        @endphp
        @if ($badgeCount > 0)
          <span class="badge-announcement">{{ $badgeCount }}</span>
        @endif
        <div class="card-body py-3">
          <i class="bi bi-megaphone-fill fs-3 text-warning"></i>
          <p class="mt-2 mb-1 fw-semibold small">Bản tin nội bộ</p>
          <a href="{{ route('employee.announcements') }}" class="btn btn-outline-primary btn-sm w-100">Xem</a>
        </div>
      </div>
    </div>

    <!-- Tuyển dụng -->
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card shadow-sm border-0 text-center h-100">
        <div class="card-body py-3">
          <i class="bi bi-briefcase-fill fs-3 text-info"></i>
          <p class="mt-2 mb-1 fw-semibold small">Tuyển dụng</p>
          <a href="{{ route('employee.recruitments') }}" class="btn btn-outline-primary btn-sm w-100">Xem</a>
        </div>
      </div>
    </div>

    <!-- Hồ sơ nhân sự -->
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card shadow-sm border-0 text-center h-100">
        <div class="card-body py-3">
          <i class="bi bi-person-lines-fill fs-3 text-success"></i>
          <p class="mt-2 mb-1 fw-semibold small">Hồ sơ nhân sự</p>
          <a href="#" class="btn btn-outline-primary btn-sm w-100">Xem</a>
        </div>
      </div>
    </div>

    <!-- Thống kê -->
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card shadow-sm border-0 text-center h-100">
        <div class="card-body py-3">
          <i class="bi bi-bar-chart-line-fill fs-3 text-danger"></i>
          <p class="mt-2 mb-1 fw-semibold small">Thống kê</p>
          <a href="#" class="btn btn-outline-primary btn-sm w-100">Xem</a>
        </div>
      </div>
    </div>

    <!-- Lịch công tác & nghỉ phép -->
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card shadow-sm border-0 text-center h-100">
        <div class="card-body py-3">
          <i class="bi bi-calendar-week fs-3 text-primary"></i>
          <p class="mt-2 mb-1 fw-semibold small">Lịch công tác</p>
          <a href="#" class="btn btn-outline-primary btn-sm w-100">Xem</a>
        </div>
      </div>
    </div>

    <!-- Thông tin cá nhân -->
    <div class="col-6 col-md-4 col-lg-2">
      <div class="card shadow-sm border-0 text-center h-100">
        <div class="card-body py-3">
          <i class="bi bi-person-circle fs-3 text-secondary"></i>
          <p class="mt-2 mb-1 fw-semibold small">Thông tin cá nhân</p>
          <a href="{{ route('profile.show') }}" class="btn btn-outline-primary btn-sm w-100">Xem</a>
        </div>
      </div>
    </div>

  </div>

  <div class="bg-white rounded shadow-sm p-4">
    <h5 class="fw-bold mb-3 text-primary">🌟 Giới thiệu về công ty</h5>
    <p class="text-muted mb-0" style="line-height: 1.8">
      Chào mừng bạn đến với hệ thống Cổng thông tin nhân viên. Tại đây, bạn có thể theo dõi các hoạt động tuyển dụng, tin tức nội bộ, thống kê nhân sự và nhiều tiện ích khác. Hệ thống được xây dựng nhằm kết nối nhân viên trong toàn công ty và hỗ trợ công việc hằng ngày một cách hiệu quả và chuyên nghiệp.
    </p>
  </div>
</div>
@endsection