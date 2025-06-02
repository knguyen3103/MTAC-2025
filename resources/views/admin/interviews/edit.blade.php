@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-primary fw-bold">✏️ Cập nhật thư mời phỏng vấn</h4>

    <form action="{{ route('admin.interviews.update', $interview->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-bold">Họ tên:</label>
            <input type="text" name="full_name" class="form-control"
                   value="{{ old('full_name', $interview->full_name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Email:</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $interview->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Vị trí:</label>
            <input type="text" name="position" class="form-control"
                   value="{{ old('position', $interview->position) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Thời gian phỏng vấn:</label>
            <input type="datetime-local" name="interview_time" class="form-control"
                   value="{{ old('interview_time', $interview->interview_time ? \Carbon\Carbon::parse($interview->interview_time)->format('Y-m-d\TH:i') : '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Ghi chú:</label>
            <textarea name="note" class="form-control" rows="4">{{ old('note', $interview->note) }}</textarea>
        </div>

        <div class="d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
            <a href="{{ route('admin.interviews.index') }}" class="btn btn-secondary">← Quay lại</a>
        </div>
    </form>
</div>
@endsection
