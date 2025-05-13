<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

 
  <style>
    .top-navbar {
      background-color: #0751aa;
      color: white;
      padding: 0.5rem 1rem;
      font-family: 'Segoe UI', sans-serif;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 999;
    }

    .nav-links .nav-item {
      position: relative;
    }

    .nav-links a.nav-link {
      color: white;
      font-size: 0.9rem;
      text-transform: uppercase;
      font-weight: 600;
      padding: 0.5rem 1rem;
      text-decoration: none;
      transition: background 0.3s;
    }

    .nav-links a.nav-link:hover {
      background-color: rgba(255, 255, 255, 0.15);
      border-radius: 4px;
    }

    .dropdown-submenu {
      position: relative;
    }

    .dropdown-submenu .dropdown-menu {
      top: 100%;
      left: 0;
      margin-top: 0.1rem;
    }

    .logo img {
      height: 40px;
    }

    .gap-3 > * {
      margin-left: 1rem;
    }

    .dropdown-menu {
      right: 0;
      left: auto;
    }
  </style>
</head>
<body style="padding-top: 64px;">

  <!-- NAVBAR -->
  <header class="top-navbar">
    <div class="container-fluid d-flex align-items-center justify-content-between">
      <div class="logo">
        <img src="/img/logo.png" alt="Logo">
      </div>
      <ul class="nav nav-links d-flex">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard') }}">TRANG CHỦ</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">BẢN TIN NỘI BỘ</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Bản tin công ty</a></li>
            <li><a class="dropdown-item" href="#">Bản tin phòng ban</a></li>
            <li><a class="dropdown-item" href="#">Bản tin cá nhân</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">TUYỂN DỤNG</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Đề xuất tuyển dụng</a></li>
            <li><a class="dropdown-item" href="#">Kế hoạch tuyển dụng</a></li>
            <li><a class="dropdown-item" href="#">Lịch phỏng vấn</a></li>
            <li><a class="dropdown-item" href="#">Đánh giá ứng viên</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">HỒ SƠ NHÂN SỰ</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Nhân sự nội bộ</a></li>
            <li><a class="dropdown-item" href="#">Nhân sự bên ngoài</a></li>
            <li><a class="dropdown-item" href="#">Quyết định</a></li>
            <li><a class="dropdown-item" href="#">Báo cáo</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">BÁO CÁO CÔNG VIỆC</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">LỊCH CÔNG TÁC & NGHỈ PHÉP</a>
        </li>
      </ul>
      <div class="extras d-flex align-items-center gap-3">
        <div class="dropdown">
          <a class="btn btn-outline-light dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Thông tin cá nhân</a></li>
            <li><a class="dropdown-item" href="{{ route('password.change') }}">Đổi mật khẩu</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST" class="px-3">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                  <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>

 
  <main class="container">
    @yield('content')
  </main>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>