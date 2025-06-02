<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="font-sans antialiased relative">
    <form method="POST" action="{{ route('logout') }}" class="logout">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm">
            <i class="bi bi-box-arrow-right"></i> Đăng xuất
        </button>
    </form>

    <div class="min-h-screen d-flex bg-light">
        <aside class="sidebar shadow">
  <div class="fs-5 fw-bold px-4 py-3 border-bottom border-blue-300">
    Cổng thông tin nhân viên
  </div>
  <nav class="mt-3">
    <a href="{{ route('dashboard') }}" class="group-title d-block {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <i class="bi bi-house-door-fill me-2"></i> Trang chủ
    </a>

    <p class="group-title" data-target="menu-announcement">
      <i class="bi bi-megaphone-fill me-2"></i> Thông báo <span class="arrow">▶</span>
    </p>
    <div id="menu-announcement" class="submenu">
      <a href="{{ route('admin.announcements.index') }}" class="{{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">Danh sách thông báo</a>
      <a href="{{ route('admin.announcements.create') }}" class="{{ request()->routeIs('admin.announcements.create') ? 'active' : '' }}">Tạo mới</a>
    </div>

    <p class="group-title" data-target="menu-recruitment">
      <i class="bi bi-briefcase-fill me-2"></i> Tuyển dụng <span class="arrow">▶</span>
    </p>
    <div id="menu-recruitment" class="submenu">
      <a href="{{ route('admin.recruitments.index') }}" class="{{ request()->routeIs('admin.recruitments.index') ? 'active' : '' }}">Đăng tin tuyển dụng</a>
      <a href="{{ route('admin.recruitments.plans.index') }}" class="{{ request()->routeIs('admin.recruitments.plans.*') ? 'active' : '' }}">Kế hoạch tuyển dụng</a>
      <a href="{{ route('admin.applicants.index') }}" class="{{ request()->routeIs('admin.applicants.index') ? 'active' : '' }}">Danh sách ứng viên</a>
      <a href="{{ route('admin.applicants.statistics') }}" class="{{ request()->routeIs('admin.applicants.statistics') ? 'active' : '' }}">Thống kê</a>
    </div>

    <p class="group-title" data-target="menu-interview">
      <i class="bi bi-calendar-check-fill me-2"></i> Phỏng vấn <span class="arrow">▶</span>
    </p>
    <div id="menu-interview" class="submenu">
      <a href="{{ route('admin.applicants.approved') }}" class="{{ request()->routeIs('admin.applicants.approved') ? 'active' : '' }}">Tiếp nhận hồ sơ</a>
      <a href="{{ route('admin.interviews.index') }}" class="{{ request()->routeIs('admin.interviews.index') ? 'active' : '' }}">Thư mời</a>
      <a href="{{ route('admin.interviews.confirmation') }}" class="{{ request()->routeIs('admin.interviews.confirmation') ? 'active' : '' }}">Trạng thái phỏng vấn</a>
      <a href="{{ route('admin.applicants.accepted') }}" class="{{ request()->routeIs('admin.applicants.accepted') ? 'active' : '' }}">Kết quả Phỏng vấn</a>
      <a href="{{ route('admin.hr.index') }}" class="{{ request()->routeIs('admin.hr.index') ? 'active' : '' }}">Quản lý hồ sơ</a>
    </div>

    <p class="group-title" data-target="menu-profile">
      <i class="bi bi-people-fill me-2"></i> Hồ sơ nhân sự <span class="arrow">▶</span>
    </p>
    <div id="menu-profile" class="submenu">
      <a href="{{ route('admin.departments.index') }}">Quản lí phòng ban</a>
      <a href="{{ route('admin.a_employees.index') }}">Quản lí nhân sự</a>
      <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
  <i class="bi bi-bar-chart-line me-2"></i> Xuất report & Thống kê
</a>

    </div>
    <p class="group-title" data-target="menu-contract">
      <i class="bi bi-file-earmark-text-fill me-2"></i> Hợp đồng & Kiêm nhiệm <span class="arrow">▶</span>
    </p>
    <div id="menu-contract" class="submenu">
      <a href="#">Quản lý hợp đồng</a>
      <a href="#">Quản lý kiêm nhiệm</a>
    </div>

    <p class="group-title" data-target="menu-personal">
      <i class="bi bi-person-lines-fill me-2"></i> Thông tin cá nhân <span class="arrow">▶</span>
    </p>
    <div id="menu-personal" class="submenu">
      <a href="#">Xem/Chỉnh sửa thông tin</a>
      <a href="#">Quản lý tài khoản</a>
    </div>

    <p class="group-title" data-target="menu-others">
      <i class="bi bi-box-seam me-2"></i> Tiện ích khác <span class="arrow">▶</span>
    </p>
    <div id="menu-others" class="submenu">
      <a href="#">Phúc lợi & chính sách</a>
      <a href="#">Cấp phát đồng phục</a>
      <a href="#">Theo dõi tiêm chủng</a>
    </div>


    </nav>
  </aside>

        <div class="flex-grow-1">
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="container py-3">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>