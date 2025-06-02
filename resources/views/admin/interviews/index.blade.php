@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-primary fw-bold">📅 Danh sách ứng viên đã được gửi thư mời</h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.interviews.invitation') }}" class="btn btn-outline-secondary">
            📩 Gửi thư mời mới
        </a>
        <a href="{{ route('admin.interviews.confirmation') }}" class="btn btn-outline-success ms-2">
            ✅ Xác nhận phỏng vấn
        </a>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Vị trí</th>
                    <th>Thời gian PV</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($invitations as $item)
                    <tr>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->position }}</td>
                        <td>
                            @if($item->interview_time)
                                {{ \Carbon\Carbon::parse($item->interview_time)->format('H:i d/m/Y') }}
                            @else
                                <span class="text-muted">Chưa đặt</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $status = $item->status ?? 'Chưa xác định';
                                $badgeClass = match($status) {
                                    'Đã gửi thư mời' => 'success',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }}">{{ $status }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.interviews.show', $item->id) }}" class="btn btn-sm btn-info">👁️ Xem</a>
                            <a href="{{ route('admin.interviews.edit', $item->id) }}" class="btn btn-sm btn-warning">✏️ Sửa</a>
                            <form action="{{ route('admin.interviews.destroy', $item->id) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Bạn có chắc muốn xóa thư mời này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">🗑️ Xoá</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Không có ứng viên nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
