@extends('layouts.admin')

@section('content')
<style>
    .form-select {
        min-width: 180px;
    }

    .badge-status {
        padding: 6px 12px;
        font-size: 0.75rem;
        border-radius: 20px;
        font-weight: 500;
    }

    .badge-cho-duyet  { background: #e2e3ff; color: #1b1e61; }
    .badge-da-duyet   { background: #d1e7dd; color: #0f5132; }
    .badge-loai       { background: #f8d7da; color: #842029; }

    h3 {
        font-weight: bold;
        color: #0d6efd;
    }
</style>

<div class="container py-5">
    <h3 class="mb-4">📁 Trạng thái hồ sơ </h3>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.applicants.index') }}" class="btn btn-outline-secondary">
            ← Quay lại danh sách
        </a>

        <form action="{{ route('admin.applicants.approved') }}" method="GET">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">-- Tất cả --</option>
                <option value="Đã duyệt" {{ request('status') == 'Đã duyệt' ? 'selected' : '' }}>Đã duyệt</option>
                <option value="Loại" {{ request('status') == 'Loại' ? 'selected' : '' }}>Loại</option>
            </select>
        </form>
    </div>

    @if(count($applicants))
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Vị trí</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicants as $a)
                <tr>
                    <td>{{ $a->full_name }}</td>
                    <td>{{ $a->email }}</td>
                    <td>{{ $a->phone }}</td>
                    <td>{{ $a->position }}</td>
                    <td>
                        @php
                            $badgeClass = match($a->status) {
                                'Chờ duyệt' => 'badge-cho-duyet',
                                'Đã duyệt' => 'badge-da-duyet',
                                'Loại' => 'badge-loai',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge badge-status {{ $badgeClass }}">{{ $a->status }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info mt-4">
        <i class="bi bi-info-circle"></i> Không có hồ sơ nào phù hợp với trạng thái lọc.
    </div>
    @endif
</div>
@endsection
