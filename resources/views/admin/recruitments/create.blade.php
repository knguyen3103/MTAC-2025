@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .form-label {
        font-weight: 600;
    }

    .form-control, .form-select {
        border-radius: 8px;
        font-size: 0.95rem;
        padding: 10px 12px;
    }

    .btn {
        font-size: 0.95rem;
        padding: 8px 16px;
        border-radius: 8px;
    }

    .btn i {
        margin-right: 6px;
    }

    .card-header h4 {
        font-size: 1.4rem;
        font-weight: bold;
    }

    .alert {
        font-size: 0.95rem;
    }
</style>

<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📋 Đăng tin tuyển dụng mới</h4>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                </div>
            @endif

            <form action="{{ route('admin.recruitments.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">🎯 Tiêu đề</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">📝 Mô tả công việc</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="department_id" class="form-label">🏢 Phòng ban</label>
                    <select name="department_id" id="department_id" class="form-select" required>
                        <option value="">-- Chọn phòng ban --</option>
                        @foreach($departments as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deadline" class="form-label">📅 Hạn nộp hồ sơ</label>
                    <input type="date" class="form-control" id="deadline" name="deadline">
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.recruitments.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Hủy bỏ
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send-check"></i> Đăng tin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
