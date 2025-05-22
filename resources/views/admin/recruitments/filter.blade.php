@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📂 Lọc hồ sơ theo trạng thái</h3>

    <form action="{{ route('admin.applicants.filter') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">-- Tất cả trạng thái --</option>
                <option value="Ứng tuyển" {{ request('status') == 'Ứng tuyển' ? 'selected' : '' }}>Ứng tuyển</option>
                <option value="Đã phỏng vấn" {{ request('status') == 'Đã phỏng vấn' ? 'selected' : '' }}>Đã phỏng vấn</option>
                <option value="Trúng tuyển" {{ request('status') == 'Trúng tuyển' ? 'selected' : '' }}>Trúng tuyển</option>
                <option value="Loại" {{ request('status') == 'Loại' ? 'selected' : '' }}>Loại</option>
            </select>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Họ tên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Vị trí</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applicants as $a)
            <tr>
                <td>{{ $a->full_name }}</td>
                <td>{{ $a->email }}</td>
                <td>{{ $a->phone }}</td>
                <td>{{ $a->position }}</td>
                <td><span class="badge bg-info text-dark">{{ $a->status }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">Không tìm thấy hồ sơ phù hợp.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
