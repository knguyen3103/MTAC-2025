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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar {
            width: 260px;
            background: linear-gradient(to bottom, #1e3a8a, #1d4ed8);
            color: white;
        }
        .sidebar .group-title {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            margin-top: 1.5rem;
            margin-bottom: 0.25rem;
            padding: 0.5rem 1.25rem;
            color: #93c5fd;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .sidebar .group-title .arrow {
            transition: transform 0.2s ease;
        }
        .sidebar .group-title.open .arrow {
            transform: rotate(90deg);
        }
        .sidebar a {
            display: block;
            padding: 0.5rem 1.25rem;
            color: white;
            font-size: 0.875rem;
            transition: background 0.2s;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .logout {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
        }
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .submenu.active {
            max-height: 500px;
        }
    </style>
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
            <div class="fs-5 fw-bold px-4 py-3 border-bottom border-blue-300">Cổng thông tin nhân viên</div>

            <nav class="mt-3">
                <div>
                    <p class="group-title" onclick="toggleMenu('recruitment', this)">
                        Tuyển dụng <span class="arrow">▶</span>
                    </p>
                    <div id="recruitment" class="submenu">
                        <a href="{{ route('admin.recruitments.create') }}">Đăng tin tuyển dụng</a>
                        <a href="#">Quản lý hồ sơ ứng viên</a>
                        <a href="#">Duyệt CV</a>
                        <a href="#">Lịch phỏng vấn</a>
                        <a href="#">Thư mời & Xác nhận</a>
                        <a href="#">Trúng tuyển</a>
                    </div>
                </div>

                <div>
                    <p class="group-title" onclick="toggleMenu('profile', this)">
                        Hồ sơ nhân sự <span class="arrow">▶</span>
                    </p>
                    <div id="profile" class="submenu">
                        <a href="#">Danh sách nhân sự</a>
                        <a href="#">Quản lý nhân viên</a>
                        <a href="#">Phân phòng, điều chuyển</a>
                        <a href="#">Xuất report & Thống kê</a>
                    </div>
                </div>

                <div>
                    <p class="group-title" onclick="toggleMenu('personal', this)">
                        Thông tin cá nhân & Liên hệ <span class="arrow">▶</span>
                    </p>
                    <div id="personal" class="submenu">
                        <a href="#">Xem/Chỉnh sửa thông tin</a>
                        <a href="#">Quản lý tài khoản</a>
                    </div>
                </div>

                <div>
                    <p class="group-title" onclick="toggleMenu('other', this)">
                        Thông tin khác <span class="arrow">▶</span>
                    </p>
                    <div id="other" class="submenu">
                        <a href="#">Phúc lợi & chính sách</a>
                        <a href="#">Cấp phát đồng phục</a>
                        <a href="#">Theo dõi tiêm chủng</a>
                    </div>
                </div>

                <div>
                    <p class="group-title" onclick="toggleMenu('contract', this)">
                        Hợp đồng & Kiêm nhiệm <span class="arrow">▶</span>
                    </p>
                    <div id="contract" class="submenu">
                        <a href="#">Quản lý hợp đồng</a>
                        <a href="#">Quản lý kiêm nhiệm</a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main content -->
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

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script>
        function toggleMenu(id, el) {
            const section = document.getElementById(id);
            section.classList.toggle('active');
            el.classList.toggle('open');
        }
    </script>
</body>
</html>