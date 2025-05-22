@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  .section-header {
    font-size: 2rem;
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
  .stat-card {
    background-color: #f8f9fa;
    color: #212529;
    border-radius: 1rem;
    padding: 1.25rem;
    box-shadow: 0 0 8px rgba(0,0,0,0.05);
    border-left: 6px solid;
  }
  .module-link {
    display: block;
    padding: 1.5rem;
    border-radius: 1rem;
    background: #f8f9fa;
    color: #212529;
    text-decoration: none;
    border-left: 5px solid;
  }
  .module-link:hover {
    background: #e9ecef;
    text-decoration: none;
  }
</style>

<div class="min-vh-100 p-4 p-md-5 bg-dark text-white">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="section-header">🎯 Tổng quan hệ thống</h1>
    <span class="text-sm text-secondary">Cập nhật: {{ now()->format('d/m/Y H:i') }}</span>
  </div>


  <div class="row g-4 mb-4">
    @foreach ([
      ['label' => 'Tổng nhân viên', 'value' => $totalEmployees ?? '...', 'color' => 'border-primary'],
      ['label' => 'Nhân viên mới', 'value' => $newHiresThisMonth ?? '...', 'color' => 'border-info'],
      ['label' => 'Ứng viên đang xử lý', 'value' => $pendingApplicants ?? '...', 'color' => 'border-success'],
      ['label' => 'Ngày công hôm nay', 'value' => $totalCheckinsToday ?? '...', 'color' => 'border-warning'],
      ['label' => 'Đơn nghỉ chờ duyệt', 'value' => $pendingLeaves ?? '...', 'color' => 'border-danger'],
      ['label' => 'Đào tạo sắp diễn ra', 'value' => $upcomingTrainingsCount ?? '...', 'color' => 'border-secondary'],
    ] as $stat)
    <div class="col-sm-6 col-lg-4 col-xl-2">
      <div class="stat-card border-start {{ $stat['color'] }} card-hover">
        <div class="text-muted small">{{ $stat['label'] }}</div>
        <div class="h4 fw-bold mt-1">{{ $stat['value'] }}</div>
      </div>
    </div>
    @endforeach
  </div>


  <div class="row g-4">
   @foreach ([
    [
        'route' => 'admin.a_employees.index',
        'icon' => '👥',
        'title' => 'Nhân sự',
        'desc' => 'Quản lý danh sách nhân sự toàn hệ thống',
        'color' => 'border-primary'
    ],
    [
        'route' => 'admin.recruitments.index',
        'icon' => '📄',
        'title' => 'Tuyển dụng',
        'desc' => 'Quản lý chiến dịch và hồ sơ ứng viên',
        'color' => 'border-success'
    ],
    [
        'route' => 'admin.users.index',
        'icon' => '🔒',
        'title' => 'Tài khoản',
        'desc' => 'Phân quyền và quản lý đăng nhập',
        'color' => 'border-warning'
    ]
] as $mod)

    <div class="col-md-6 col-lg-4">
      <a href="{{ route($mod['route']) }}" class="module-link {{ $mod['color'] ?? 'border-secondary' }} card-hover">
        <h5 class="mb-1">{{ $mod['icon'] }} {{ $mod['title'] }}</h5>
        <div class="text-muted small">{{ $mod['desc'] }}</div>
      </a>
    </div>
    @endforeach
  </div>

 
  <div class="mt-5 bg-light text-dark rounded-3 shadow p-4">
    <h5 class="mb-3">📢 Thông báo nội bộ</h5>
    <div class="border-top pt-2">
      @forelse($announcements ?? [] as $news)
        <div class="py-2 border-bottom">
          <strong>{{ $news->title }}</strong>
          <div class="text-muted small">{{ $news->created_at->format('d/m/Y') }}</div>
        </div>
      @empty
        <p class="text-muted">Chưa có thông báo nào.</p>
      @endforelse
    </div>
  </div>


  <div class="mt-5 bg-light text-dark rounded-3 shadow p-4">
    <h5 class="mb-3">📊 Biểu đồ thống kê</h5>
    <div class="h-64 d-flex align-items-center justify-content-center text-muted border border-dashed rounded">
      (Tích hợp biểu đồ ở đây...)
    </div>
  </div>

 
  <div class="mt-5 bg-light text-dark rounded-3 shadow p-4 overflow-auto">
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

 
  <div class="mt-5 bg-light text-dark rounded-3 shadow p-4 overflow-auto">
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
