@extends('layouts.admin')

@section('content')
<style>
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table .btn-outline-primary,
    .table .btn-success {
        padding: 4px 10px;
        font-size: 0.85rem;
        border-radius: 6px;
    }

    .form-select-sm {
        padding: 4px 8px;
        font-size: 0.75rem;
        border-radius: 12px;
        min-width: 130px;
    }

    .badge-status {
        padding: 6px 12px;
        font-size: 0.75rem;
        border-radius: 20px;
    }

    .badge-success {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    h3 {
        color: #086db5;
        font-weight: bold;
    }
</style>

<div class="container mt-4">
    <h3 class="mb-4">📋 Kết quả phỏng vấn</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Vị trí</th>
                    <th>Trạng thái</th>
                    <th>CV</th>
                    <th>Xác nhận hồ sơ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applicants as $applicant)
                <tr>
                    <td>{{ $applicant->full_name }}</td>
                    <td>{{ $applicant->email }}</td>
                    <td>{{ $applicant->phone }}</td>
                    <td>{{ $applicant->position }}</td>
                    <td>
                        <span class="badge badge-status badge-success">{{ $applicant->status }}</span>
                    </td>
                    <td>
                        @if ($applicant->cv_path)
                            <a href="{{ asset('storage/' . $applicant->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                📄 Xem CV
                            </a>
                        @else
                            <span class="text-muted">Chưa có</span>
                        @endif
                    </td>
                    <td>

                        <form action="{{ route('admin.applicants.confirm', $applicant->id) }}" method="POST" class="mb-2">
                            @csrf
                            <select name="confirmation" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">-- Chọn --</option>
                                <option value="Đã đồng ý" {{ $applicant->confirmation == 'Đã đồng ý' ? 'selected' : '' }}>✅ Đã đồng ý</option>
                                <option value="Không đồng ý" {{ $applicant->confirmation == 'Không đồng ý' ? 'selected' : '' }}>❌ Không đồng ý</option>
                                <option value="Khác" {{ $applicant->confirmation == 'Khác' ? 'selected' : '' }}>⏳ Chờ</option>
                            </select>
                        </form>

                        @if($applicant->confirmation === 'Đã đồng ý')
                        <form action="{{ route('admin.applicants.to_hr', $applicant->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-success" type="submit">
                                📂 Chuyển HCNS
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => alert.classList.remove('show'));
    }, 5000);
</script>
@endsection
