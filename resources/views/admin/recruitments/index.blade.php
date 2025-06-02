@extends('layouts.admin')

@section('content')
<!-- Bootstrap Icons nếu chưa có -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .container h2 {
        font-size: 1.6rem;
        font-weight: bold;
        border-left: 6px solid #0d6efd;
        padding-left: 12px;
        margin-bottom: 1.5rem;
    }

    .btn i {
        margin-right: 6px;
    }

    .btn-outline-warning,
    .btn-outline-danger {
        font-size: 0.875rem;
        padding: 6px 12px;
        border-radius: 8px;
    }

    .table {
        font-size: 0.925rem;
        background-color: #fff;
    }

    .table th,
    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table thead th {
        background-color: #f0f4f8;
    }

    .table-responsive {
        border-radius: 10px;
        overflow-x: auto;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .alert {
        font-size: 0.95rem;
    }

    .btn-primary {
        font-size: 0.9rem;
        padding: 8px 16px;
        border-radius: 8px;
    }

    .btn-close {
        font-size: 0.75rem;
    }

    .action-buttons .btn {
        margin-right: 6px;
    }

    @media (max-width: 768px) {
        .container {
            padding: 16px;
        }

        .table {
            font-size: 0.85rem;
        }
    }
</style>

<div class="container py-4">
    <h2 class="text-primary">📄 Danh sách đợt tuyển dụng</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.recruitments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tạo đợt tuyển dụng mới
        </a>
    </div>

    @if ($recruitments->count())
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>Tiêu đề</th>
                        <th>Phòng ban</th>
                        <th>Hạn nộp</th>
                        <th>Ngày tạo</th>
                        <th style="width: 160px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recruitments as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->department ?? '---' }}</td>
                            <td>{{ $item->deadline ?? '---' }}</td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td class="action-buttons text-center">
                                <a href="{{ route('admin.recruitments.edit', $item->id) }}" class="btn btn-outline-warning btn-sm" title="Sửa">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.recruitments.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" type="submit" title="Xóa">
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
            <i class="bi bi-info-circle"></i> Hiện chưa có đợt tuyển dụng nào. Hãy tạo mới ngay!
        </div>
    @endif
</div>
@endsection
