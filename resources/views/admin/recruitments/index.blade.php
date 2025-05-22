@extends('layouts.admin')

@section('content')
<style>
    .table td, .table th {
        vertical-align: middle;
        text-align: center;
    }

    .btn-outline-warning,
    .btn-outline-danger {
        padding: 4px 10px;
        font-size: 0.875rem;
    }

    .table-responsive {
        border-radius: 8px;
        overflow-x: auto;
    }

    .alert {
        margin-bottom: 1rem;
    }

    .container h2 {
        font-size: 1.5rem;
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 fw-bold text-primary">
        📄 Danh sách đợt tuyển dụng
    </h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    @endif

    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.recruitments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tạo đợt tuyển dụng mới
        </a>
    </div>

    @if ($recruitments->count())
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover table-bordered align-middle">
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
                            <td>
                                <a href="{{ route('admin.recruitments.edit', $item->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.recruitments.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
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
            <i class="bi bi-info-circle"></i> Tạm thời chưa có dữ liệu tuyển dụng. Bạn có thể tạo mới.
        </div>
    @endif
</div>
@endsection
