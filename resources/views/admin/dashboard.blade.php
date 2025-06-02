@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
  .section-header {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
  }

  .stat-box {
    background-color: #ffffff;
    border-radius: 1rem;
    padding: 1.25rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    border-left: 6px solid;
    transition: all 0.3s ease;
  }

  .stat-title {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
  }

  .stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #000;
  }

  .module-card {
    display: block;
    padding: 1.5rem;
    border-radius: 1rem;
    color: #212529;
    text-decoration: none;
    background-color: #ffffff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    transition: 0.3s ease;
    border-left: 6px solid;
  }

  .module-card h5 {
    font-size: 1rem;
    font-weight: bold;
    margin-bottom: 0.25rem;
  }

  .module-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    text-decoration: none;
  }

  .section-box {
    background-color: #ffffff;
    border-radius: 1rem;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
    padding: 1.5rem;
    margin-bottom: 2rem;
  }
</style>

<div class="min-vh-100 p-4 bg-white text-dark">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="section-header">🎯 Trang dành cho Admin !</h1>
    <span class="text-muted">{{ now()->format('d/m/Y H:i') }}</span>
  </div>

  {{-- Dòng thống kê --}}
  <div class="row g-4 mb-5">
    @foreach([
      ['label' => 'Tổng nhân viên', 'value' => $totalEmployees ?? '...', 'color' => '#4f46e5'],
      ['label' => 'Nhân viên mới', 'value' => $newHiresThisMonth ?? '...', 'color' => '#0ea5e9'],
      ['label' => 'Ứng viên đang xử lý', 'value' => $pendingApplicants ?? '...', 'color' => '#10b981'],
      ['label' => 'Ngày công hôm nay', 'value' => $totalCheckinsToday ?? '...', 'color' => '#facc15'],
      ['label' => 'Đơn nghỉ chờ duyệt', 'value' => $pendingLeaves ?? '...', 'color' => '#ef4444'],
      ['label' => 'Đào tạo sắp diễn ra', 'value' => $upcomingTrainingsCount ?? '...', 'color' => '#64748b'],
    ] as $stat)
    <div class="col-6 col-md-4 col-xl-2">
      <div class="stat-box" style="border-left-color: {{ $stat['color'] }};">
        <div class="stat-title">{{ $stat['label'] }}</div>
        <div class="stat-value">{{ $stat['value'] }}</div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Các module --}}
  <div class="row g-4 mb-5">
    @foreach([
      ['route' => 'admin.a_employees.index', 'icon' => '👥', 'title' => 'Nhân sự', 'desc' => 'Quản lý danh sách nhân sự', 'color' => '#4f46e5'],
      ['route' => 'admin.recruitments.index', 'icon' => '📄', 'title' => 'Tuyển dụng', 'desc' => 'Chiến dịch & ứng viên', 'color' => '#10b981'],
      ['route' => 'admin.users.index', 'icon' => '🔒', 'title' => 'Tài khoản', 'desc' => 'Phân quyền & đăng nhập', 'color' => '#f59e0b'],
    ] as $mod)
    <div class="col-md-6 col-lg-4">
      <a href="{{ route($mod['route']) }}" class="module-card" style="border-left-color: {{ $mod['color'] }};">
        <h5 style="color: {{ $mod['color'] }}">{{ $mod['icon'] }} {{ $mod['title'] }}</h5>
        <div class="text-muted small">{{ $mod['desc'] }}</div>
      </a>
    </div>
    @endforeach
  </div>

  {{-- Thông báo --}}
  <div class="section-box">
    <h5 class="mb-3">📢 Thông báo nội bộ</h5>
    @forelse($announcements ?? [] as $news)
    <div class="py-2 border-bottom">
      <strong>{{ $news->title }}</strong>
      <div class="text-muted small">{{ $news->created_at->format('d/m/Y') }}</div>
    </div>
    @empty
    <p class="text-muted">Chưa có thông báo nào.</p>
    @endforelse
  </div>

  {{-- Biểu đồ --}}
  <div class="section-box">
    <h5 class="mb-3">📊 Biểu đồ thống kê</h5>
    <div class="border border-dashed rounded p-5 text-center text-muted">
      (Biểu đồ sẽ hiển thị tại đây...)
    </div>
  </div>

  {{-- Nhân viên mới --}}
  <div class="section-box overflow-auto">
    <h5 class="mb-3">👤 Nhân viên mới nhất</h5>
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>Họ tên</th>
          <th>Phòng ban</th>
          <th>Ngày vào</th>
        </tr>
      </thead>
      <tbody>
        @forelse($employees ?? [] as $emp)
        <tr>
          <td>{{ $emp->full_name }}</td>
          <td>{{ $emp->department_name ?? '-' }}</td>
          <td>{{ $emp->created_at->format('d/m/Y') }}</td>
        </tr>
        @empty
        <tr><td colspan="3" class="text-muted">Không có dữ liệu.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Tài khoản mới --}}
  <div class="section-box overflow-auto">
    <h5 class="mb-3">🔐 Tài khoản mới nhất</h5>
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>Tên đăng nhập</th>
          <th>Email</th>
          <th>Vai trò</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users ?? [] as $user)
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->role->name ?? '-' }}</td>
        </tr>
        @empty
        <tr><td colspan="3" class="text-muted">Không có dữ liệu.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
