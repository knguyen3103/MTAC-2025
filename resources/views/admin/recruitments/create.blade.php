@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📋 Đăng tin tuyển dụng mới</h4>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
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
                    <label for="department" class="form-label">🏢 Phòng ban</label>
                    <input type="text" class="form-control" id="department" name="department">
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
                        ✅ Đăng tin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
