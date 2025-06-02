@extends('layouts.admin')

@section('content')
<!-- Bootstrap Icons nếu bạn muốn dùng -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .form-label {
        font-weight: 600;
    }

    .form-select, .form-control {
        font-size: 0.95rem;
        border-radius: 8px;
        padding: 10px 12px;
    }

    .btn {
        padding: 8px 16px;
        font-size: 0.95rem;
        border-radius: 8px;
    }

    .container h4 {
        font-size: 1.4rem;
        border-left: 6px solid #28a745;
        padding-left: 12px;
    }

    .form-section {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 24px;
        max-width: 700px;
    }

    @media (max-width: 768px) {
        .container h4 {
            font-size: 1.2rem;
        }
    }
</style>

<div class="container py-4">
    <h4 class="text-success fw-bold mb-4">📋 Trạng thái phỏng vấn</h4>

    <div class="form-section">
        <form action="{{ route('admin.interviews.submit_confirmation') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="full_name" class="form-label">👤 Họ tên ứng viên</label>
                <select name="full_name" id="full_name" class="form-select" required>
                    <option value="">-- Chọn ứng viên đã được gửi thư mời --</option>
                    @foreach($candidates as $candidate)
                        <option value="{{ $candidate->full_name }}">
                            {{ $candidate->full_name }} ({{ $candidate->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="confirmation_status" class="form-label">📌 Trạng thái xác nhận</label>
                <select name="confirmation_status" id="confirmation_status" class="form-select" required>
                    <option value="">-- Chọn --</option>
                    <option value="Đã xác nhận">✅ Đã xác nhận</option>
                    <option value="Chưa xác nhận">❌ Chưa xác nhận</option>
                    <option value="Khác">⏳ Khác</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">📝 Ghi chú thêm <small class="text-muted">(tuỳ chọn)</small></label>
                <textarea name="note" id="note" class="form-control" rows="3"
                    placeholder="Ví dụ: Lý do chưa xác nhận, thay đổi thời gian..."></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check2-circle"></i> Xác nhận
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
