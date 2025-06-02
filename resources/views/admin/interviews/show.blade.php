@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-primary fw-bold">👁️ Thông tin chi tiết thư mời phỏng vấn</h4>

    <div class="card">
        <div class="card-body">
            <p><strong>Họ tên:</strong> {{ $interview->full_name }}</p>
            <p><strong>Email:</strong> {{ $interview->email }}</p>
            <p><strong>Vị trí:</strong> {{ $interview->position }}</p>
            <p><strong>Thời gian phỏng vấn:</strong> 
                @if($interview->interview_time)
                    {{ \Carbon\Carbon::parse($interview->interview_time)->format('H:i d/m/Y') }}
                @else
                    <span class="text-muted">Chưa đặt</span>
                @endif
            </p>
            <p><strong>Trạng thái:</strong> 
                <span class="badge bg-{{ $interview->status === 'Đã gửi thư mời' ? 'success' : 'secondary' }}">
                    {{ $interview->status ?? 'Chưa gửi' }}
                </span>
            </p>
            @if($interview->note)
                <p><strong>Ghi chú:</strong><br> {!! nl2br(e($interview->note)) !!}</p>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.interviews.index') }}" class="btn btn-secondary mt-3">← Quay lại danh sách</a>
</div>
@endsection
