@extends('layouts.admin')

@section('content')
<style>
    .table th,
    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .form-select-sm {
        padding: 4px 8px;
        font-size: 0.75rem;
        border-radius: 12px;
        height: auto;
        min-width: 120px;
        line-height: 1.4;
    }

    .badge {
        padding: 6px 12px;
        font-size: 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        display: inline-block;
    }

    .badge-success {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .badge-warning {
        background-color: #fff3cd;
        color: #664d03;
    }

    .badge-danger {
        background-color: #f8d7da;
        color: #842029;
    }

    .badge-muted {
        background-color: #e2e3e5;
        color: #6c757d;
    }

    .btn-outline-primary,
    .btn-outline-danger {
        padding: 4px 8px;
        font-size: 0.75rem;
        border-radius: 8px;
    }

    h4 {
        color: #0d6efd;
        font-weight: bold;
    }
</style>

<div class="container py-4">
    <h4 class="mb-4">📂 Trạng thái hồ sơ nhân sự</h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="flash-success">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Vị trí</th>
                    <th>Trạng thái tuyển dụng</th>
                    <th>CV</th>
                    <th>Hồ sơ nhân sự</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applicants as $a)
                    <tr>
                        <td>{{ $a->full_name }}</td>
                        <td>{{ $a->email }}</td>
                        <td>{{ $a->position }}</td>
                        <td>
                            <span class="badge 
                                {{ $a->status == 'Trúng tuyển' ? 'badge-success' :
                                   ($a->status == 'Đang phỏng vấn' ? 'badge-warning' :
                                   ($a->status == 'Loại' ? 'badge-danger' : 'badge-muted')) }}">
                                {{ $a->status }}
                            </span>
                        </td>
                        <td>
                            @if($a->cv_path)
                                <a href="{{ asset('storage/' . $a->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">📄 Xem CV</a>
                            @else
                                <span class="text-muted">Chưa có</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.hr.update_file_status', $a->id) }}">
                                @csrf
                                <select name="hr_file_status" class="form-select form-select-sm" onchange="if(this.dataset.old != this.value) this.form.submit();" data-old="{{ $a->hr_file_status }}">
                                    <option value="">-- Chọn --</option>
                                    <option value="Đủ HS" {{ $a->hr_file_status == 'Đủ HS' ? 'selected' : '' }}>Đủ HS</option>
                                    <option value="Thiếu HS" {{ $a->hr_file_status == 'Thiếu HS' ? 'selected' : '' }}>Thiếu HS</option>
                                    <option value="Chưa nhận" {{ $a->hr_file_status == 'Chưa nhận' ? 'selected' : '' }}>Chưa nhận</option>
                                    <option value="Khác" {{ $a->hr_file_status == 'Khác' ? 'selected' : '' }}>Khác</option>
                                </select>
                            </form>

                            @if($a->hr_file_status)
                                <div class="mt-2">
                                    <span class="badge 
                                        {{ $a->hr_file_status == 'Đủ HS' ? 'badge-success' :
                                           ($a->hr_file_status == 'Thiếu HS' ? 'badge-warning' :
                                           ($a->hr_file_status == 'Chưa nhận' ? 'badge-danger' : 'badge-muted')) }}">
                                        {{ $a->hr_file_status == 'Đủ HS' ? '✔️' :
                                           ($a->hr_file_status == 'Thiếu HS' ? '⚠️' :
                                           ($a->hr_file_status == 'Chưa nhận' ? '📭' : '❓')) }}
                                        {{ $a->hr_file_status }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.hr.remove_file_status', $a->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa trạng thái hồ sơ nhân sự này?')">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                    🗑️
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Ẩn alert sau 5s
    setTimeout(() => {
        const flash = document.getElementById('flash-success');
        if (flash) flash.classList.remove('show');
    }, 5000);
</script>
@endsection
