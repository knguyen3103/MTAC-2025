@extends('layouts.admin')

@section('content')
<style>
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table .btn {
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 6px;
    }

    .table .btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
    }

    .table .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #fff;
    }

    .table .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .badge-status {
        padding: 6px 10px;
        font-size: 0.75rem;
        border-radius: 20px;
        font-weight: 500;
    }

    .badge-cho-duyet     { background: #e2e3ff; color: #1b1e61; }
    .badge-da-duyet      { background: #d1e7dd; color: #0f5132; }
    .badge-loai          { background: #f8d7da; color: #842029; }

    .form-select {
        min-width: 200px;
    }

    .container h3 {
        font-weight: bold;
        color: #0d6efd;
    }
</style>

<div class="container py-5">
    <h3 class="mb-4">📋 Danh sách ứng viên</h3>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
    </div>
    @endif

    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <a href="{{ route('admin.applicants.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Thêm ứng viên
        </a>

        <form action="{{ route('admin.applicants.index') }}" method="GET">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">-- Tất cả trạng thái --</option>
                <option value="Chờ duyệt" {{ request('status') == 'Chờ duyệt' ? 'selected' : '' }}>Chờ duyệt</option>
                <option value="Đã duyệt" {{ request('status') == 'Đã duyệt' ? 'selected' : '' }}>Đã duyệt</option>
                <option value="Loại" {{ request('status') == 'Loại' ? 'selected' : '' }}>Loại</option>
            </select>
        </form>
    </div>

    @if(count($applicants))
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Ngày sinh</th>
                    <th>Chuyên ngành</th>
                    <th>Trường học</th>
                    <th>Vị trí</th>
                    <th>Trạng thái</th>
                    <th>CV</th>
                    <th style="width: 150px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicants as $a)
                <tr>
                    <td>{{ $a->full_name }}</td>
                    <td>{{ $a->email }}</td>
                    <td>{{ $a->phone }}</td>
                    <td>{{ $a->birthday ? \Carbon\Carbon::parse($a->birthday)->format('d/m/Y') : '' }}</td>
                    <td>{{ $a->major }}</td>
                    <td>{{ $a->university }}</td>
                    <td>{{ $a->position }}</td>
                    <td>
                        @php
                            $badgeClass = match($a->status) {
                                'Chờ duyệt' => 'badge-cho-duyet',
                                'Đã duyệt' => 'badge-da-duyet',
                                'Loại' => 'badge-loai',
                                default => 'badge-secondary'
                            };
                        @endphp
                        <span class="badge badge-status {{ $badgeClass }}">{{ $a->status }}</span>
                    </td>
                    <td>
                        @if ($a->cv_path)
                            <a href="{{ asset('storage/' . $a->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                📄 Xem CV
                            </a>
                        @else
                            <span class="text-muted">Chưa có</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.applicants.edit', $a->id) }}" class="btn btn-sm btn-outline-warning me-1">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('admin.applicants.destroy', $a->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Bạn có chắc muốn xóa ứng viên này?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info mt-4">
        <i class="bi bi-info-circle"></i> Chưa có ứng viên nào.
    </div>
    @endif
</div>
@endsection
