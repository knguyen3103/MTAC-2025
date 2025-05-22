@extends('layouts.admin')

@section('content')
<style>
    .form-wrapper {
        max-width: 720px;
        margin: 0 auto;
        background: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
    }

    .form-wrapper h4 {
        font-weight: bold;
        color: #086db5;
    }

    .form-wrapper label {
        font-weight: 500;
        margin-bottom: 4px;
    }

    .form-wrapper .form-label span {
        color: red;
    }

    .form-wrapper .form-control,
    .form-wrapper .form-select {
        border-radius: 8px;
        padding: 10px 12px;
    }

    .form-wrapper .btn {
        border-radius: 8px;
        padding: 8px 20px;
        font-weight: 500;
    }

    .form-wrapper .btn-outline-primary {
        font-size: 0.875rem;
    }
</style>

<div class="form-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            {{ isset($applicant) ? '✏️ Cập nhật ứng viên' : '➕ Thêm ứng viên mới' }}
        </h4>
        <a href="{{ route('admin.applicants.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Trở về
        </a>
    </div>

    <form method="POST"
        action="{{ isset($applicant) ? route('admin.applicants.update', $applicant->id) : route('admin.applicants.store') }}"
        enctype="multipart/form-data">
        @csrf
        @if(isset($applicant)) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label for="full_name" class="form-label">Họ và tên <span>*</span></label>
                <input type="text" id="full_name" name="full_name" class="form-control"
                    value="{{ old('full_name', $applicant->full_name ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Email <span>*</span></label>
                <input type="email" id="email" name="email" class="form-control"
                    value="{{ old('email', $applicant->email ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" id="phone" name="phone" class="form-control"
                    value="{{ old('phone', $applicant->phone ?? '') }}">
            </div>

            <div class="col-md-6">
                <label for="birthday" class="form-label">Ngày sinh</label>
                <input type="date" id="birthday" name="birthday" class="form-control"
                    value="{{ old('birthday', $applicant->birthday ?? '') }}">
            </div>

            <div class="col-md-6">
                <label for="major" class="form-label">Chuyên ngành</label>
                <input type="text" id="major" name="major" class="form-control"
                    value="{{ old('major', $applicant->major ?? '') }}">
            </div>

            <div class="col-md-6">
                <label for="university" class="form-label">Trường học</label>
                <input type="text" id="university" name="university" class="form-control"
                    value="{{ old('university', $applicant->university ?? '') }}">
            </div>

            <div class="col-md-6">
                <label for="position" class="form-label">Vị trí ứng tuyển</label>
                <input type="text" id="position" name="position" class="form-control"
                    value="{{ old('position', $applicant->position ?? '') }}">
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">Trạng thái</label>
                @php $status = old('status', $applicant->status ?? 'Ứng tuyển'); @endphp
                <select name="status" id="status" class="form-select">
                    <option value="Ứng tuyển" {{ $status == 'Ứng tuyển' ? 'selected' : '' }}>Ứng tuyển</option>
                    <option value="Đã phỏng vấn" {{ $status == 'Đã phỏng vấn' ? 'selected' : '' }}>Đã phỏng vấn</option>
                    <option value="Trúng tuyển" {{ $status == 'Trúng tuyển' ? 'selected' : '' }}>Trúng tuyển</option>
                    <option value="Loại" {{ $status == 'Loại' ? 'selected' : '' }}>Loại</option>
                </select>
            </div>

            <div class="col-12">
                <label for="cv_file" class="form-label">Tải lên CV (PDF, DOCX)</label>
                <input type="file" name="cv_file" id="cv_file" class="form-control" accept=".pdf,.doc,.docx">
                @if(isset($applicant) && $applicant->cv_path)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $applicant->cv_path) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            📎 Xem CV hiện tại
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.applicants.index') }}" class="btn btn-secondary">Huỷ</a>
            <button type="submit" class="btn btn-success">Lưu</button>
        </div>
    </form>
</div>
@endsection
