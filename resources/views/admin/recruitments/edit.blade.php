@extends('layouts.admin')

@section('content')
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
                    <label for="department" class="form-label">🏢 Phòng ban</label>
                    <input type="text" class="form-control" id="department" name="department"
                           value="{{ old('department', $recruitment->department) }}">
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
