@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">📁 Trạng thái phỏng vấn</h3>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.applicants.index') }}" class="btn btn-outline-secondary">
            ← Quay lại danh sách
        </a>

     
        <form action="{{ route('admin.applicants.approved') }}" method="GET">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">-- Tất cả đã duyệt --</option>
                <option value="Đã phỏng vấn" {{ request('status') == 'Đã phỏng vấn' ? 'selected' : '' }}>Đã phỏng vấn</option>
                <option value="Trúng tuyển" {{ request('status') == 'Trúng tuyển' ? 'selected' : '' }}>Trúng tuyển</option>
                <option value="Loại" {{ request('status') == 'Loại' ? 'selected' : '' }}>Loại</option>
            </select>
        </form>
    </div>

    @if(count($applicants))
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary">
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
                                        'Đã phỏng vấn' => 'bg-info',
                                        'Trúng tuyển' => 'bg-success',
                                        'Loại' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $a->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info mt-4">
            <i class="bi bi-info-circle"></i> Không có CV nào phù hợp với trạng thái lọc.
        </div>
    @endif
</div>
@endsection
