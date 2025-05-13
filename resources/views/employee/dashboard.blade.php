@extends('layouts.employee')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  .section-header {
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }
  .card-hover {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s;
  }
  .card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 10px rgba(0,0,0,0.15);
  }
</style>

<div class="container py-4">
  <h1 class="section-header">📄 Trang tổng quan cá nhân</h1>

  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title">Xin chào, {{ auth()->user()->name }}</h5>
      <p class="card-text mb-1"><strong>Email:</strong> {{ auth()->user()->email }}</p>
      <p class="card-text"><strong>Vai trò:</strong> {{ auth()->user()->role->name ?? '---' }}</p>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="card text-bg-light">
        <div class="card-body">
          <h5 class="card-title">🕛 Ngày công trong tháng</h5>
          <p class="card-text fs-4 fw-bold">{{ $workingDaysThisMonth ?? '...' }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card text-bg-light">
        <div class="card-body">
          <h5 class="card-title">✉️ Phép còn lại</h5>
          <p class="card-text fs-4 fw-bold">{{ $remainingLeaves ?? '...' }}</p>
        </div>
      </div>
    </div>
  </div>


  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-4">
    <div class="col">
      <div class="card border-primary h-100">
        <div class="card-body text-primary">
          <h5 class="card-title"><i class="bi bi-person-vcard"></i> Thông tin cá nhân</h5>
          <p class="card-text">Xem và cập nhật hồ sơ cá nhân của bạn.</p>
          <a href="{{ route('profile.show') }}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card border-success h-100">
        <div class="card-body text-success">
          <h5 class="card-title"><i class="bi bi-calendar-check"></i> Xin nghỉ phép</h5>
          <p class="card-text">Gửi yêu cầu nghỉ phép hoặc xem lịch sử.</p>
          <a href="#" class="btn btn-outline-success btn-sm">Gửi yêu cầu</a>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card border-warning h-100">
        <div class="card-body text-warning">
          <h5 class="card-title"><i class="bi bi-clock-history"></i> Lịch sử chấm công</h5>
          <p class="card-text">Xem các ngày công đã ghi nhận.</p>
          <a href="#" class="btn btn-outline-warning btn-sm">Xem ngay</a>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card border-info h-100">
        <div class="card-body text-info">
          <h5 class="card-title"><i class="bi bi-bar-chart-line"></i> Thống kê cá nhân</h5>
          <p class="card-text">Tổng hợp điểm chuyên cần, đánh giá, tiến độ cá nhân.</p>
          <a href="#" class="btn btn-outline-info btn-sm">Xem thống kê</a>
        </div>
      </div>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title">📢 Thông báo nội bộ</h5>
      <ul class="list-group list-group-flush">
        @forelse ($announcements ?? [] as $note)
          <li class="list-group-item">{{ $note->title }} <small class="text-muted">({{ $note->created_at->format('d/m/Y') }})</small></li>
        @empty
          <li class="list-group-item text-muted">Chưa có thông báo nào.</li>
        @endforelse
      </ul>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title">📅 Lịch công tác & nghỉ phép</h5>
      <ul class="list-group list-group-flush">
        @forelse ($schedules ?? [] as $event)
          <li class="list-group-item">
            <strong>{{ $event->title }}</strong> - <span class="text-muted">{{ $event->date->format('d/m/Y') }}</span>
          </li>
        @empty
          <li class="list-group-item text-muted">Chưa có sự kiện nào sắp tới.</li>
        @endforelse
      </ul>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">📊 Tình trạng công việc</h5>
      <div class="text-muted text-center p-5 border border-dashed rounded">
        (Tích hợp biểu đồ trạng thái công việc ở đây...)
      </div>
    </div>
  </div>
</div>
@endsection
