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

    .text-danger {
        font-size: 0.875rem;
    }
</style>

<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📋 Đăng tin tuyển dụng mới</h4>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Vui lòng kiểm tra lại các trường sau:
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.recruitments.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">🎯 Tiêu đề</label>
                    <input type="text" class="form-control" id="title" name="title" 
                        value="{{ old('title') }}" required>
                    @error('title')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">📝 Mô tả công việc</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="department_id" class="form-label">🏢 Phòng ban</label>
                    <select name="department_id" id="department_id" class="form-select" required>
                        <option value="">-- Chọn phòng ban --</option>
                        @foreach($departments as $id => $name)
                            <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deadline" class="form-label">📅 Hạn nộp hồ sơ</label>
                    <input type="date" class="form-control" id="deadline" name="deadline"
                        value="{{ old('deadline') }}">
                    @error('deadline')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
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
