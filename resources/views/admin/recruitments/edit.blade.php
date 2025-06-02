@extends('layouts.admin')

@section('content')
<!-- Bootstrap Icons nếu chưa có -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .form-label {
        font-weight: 600;
    }

    .form-control {
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

    .alert-danger ul {
        margin-bottom: 0;
        padding-left: 18px;
    }

    @media (max-width: 768px) {
        .card-header h4 {
            font-size: 1.2rem;
        }
    }
</style>

<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📝 Cập nhật tin tuyển dụng</h4>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
           <form action="{{ route('admin.recruitments.update', $recruitment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">🎯 Tiêu đề</label>
                    <input type="text" class="form-control" id="title" name="title"
                           value="{{ old('title', $recruitment->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">📝 Mô tả công việc</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $recruitment->description) }}</textarea>
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
                    <input type="date" class="form-control" id="deadline" name="deadline"
                           value="{{ old('deadline', $recruitment->deadline) }}">
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.recruitments.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-warning text-white">
                        <i class="bi bi-check2-circle"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
