@extends('layouts.admin')

@section('content')
<style>
    .form-label {
        font-weight: 500;
    }

    .form-control[readonly] {
        background-color: #f8f9fa;
    }

    .btn-primary {
        padding: 10px 20px;
        font-weight: 500;
        border-radius: 8px;
    }

    .form-section {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        max-width: 720px;
        margin: auto;
    }

    h4.text-primary {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    h4.text-primary i {
        color: #086db5;
    }
</style>

<div class="container py-4">
    <div class="form-section">
        <h4 class="text-primary fw-bold mb-4">
            <i class="bi bi-envelope-paper-fill"></i> Gửi thư mời phỏng vấn
        </h4>

        <form action="{{ route('admin.interviews.send_invitation') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="applicant_id" class="form-label">👤 Chọn ứng viên</label>
                <select name="applicant_id" id="applicant_id" class="form-select" onchange="fillApplicantInfo()" required>
                    <option value="">-- Chọn ứng viên đã duyệt --</option>
                    @foreach($candidates as $c)
                        <option value="{{ $c->id }}"
                            data-name="{{ $c->full_name }}"
                            data-email="{{ $c->email }}"
                            data-position="{{ $c->position }}">
                            {{ $c->full_name }} - {{ $c->position }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">📛 Họ tên</label>
                <input type="text" name="full_name" id="full_name" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">📧 Email</label>
                <input type="email" name="email" id="email" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">📌 Vị trí ứng tuyển</label>
                <input type="text" name="position" id="position" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">🕒 Thời gian phỏng vấn</label>
                <input type="datetime-local" name="interview_time" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">📝 Ghi chú thêm</label>
                <textarea name="note" class="form-control" rows="3" placeholder="VD: Địa điểm phỏng vấn, người liên hệ..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary">📤 Gửi thư mời</button>
        </form>
    </div>
</div>

<script>
function fillApplicantInfo() {
    const select = document.getElementById('applicant_id');
    const selected = select.options[select.selectedIndex];
    document.getElementById('full_name').value = selected.dataset.name || '';
    document.getElementById('email').value = selected.dataset.email || '';
    document.getElementById('position').value = selected.dataset.position || '';
}
</script>
@endsection
