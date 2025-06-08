@extends('layouts.employee')

@section('content')
<style>
  .announcement-section h5 {
    font-size: 1.1rem;
    font-weight: 600;
  }
  .announcement-section .badge {
    font-size: 0.75rem;
    padding: 0.35em 0.6em;
  }
  .announcement-section .card-text {
    font-size: 0.925rem;
  }
  .announcement-section .card {
    transition: 0.3s;
  }
  .announcement-section .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  }
</style>

<div class="container mt-4 announcement-section">
  <h3 class="mb-4 fw-bold text-primary">
    <i class="bi bi-megaphone-fill me-2"></i> Bản tin nội bộ
  </h3>

  @php
    $important = $announcements->where('do_quan_trong', 'Quan trọng');
    $normal = $announcements->where('do_quan_trong', 'Thường');
  @endphp

  @if ($important->count())
    <h5 class="text-danger mb-3">🔔 Thông báo quan trọng</h5>
    @foreach ($important as $item)
      <div class="card mb-3 border-danger">
        <div class="card-body">
          <h5 class="card-title mb-1 text-danger">
            {{ $item->tieu_de }}
            <span class="badge bg-danger ms-2">Quan trọng</span>
          </h5>
          <p class="card-text text-muted small mb-2">
            Hiển thị:
            @if($item->hien_thi_tu) từ {{ \Carbon\Carbon::parse($item->hien_thi_tu)->format('d/m/Y') }} @endif
            @if($item->hien_thi_den) đến {{ \Carbon\Carbon::parse($item->hien_thi_den)->format('d/m/Y') }} @endif
          </p>
          <div class="card-text" style="white-space: pre-line;">{{ $item->noi_dung }}</div>
        </div>
      </div>
    @endforeach
  @endif

  @if ($normal->count())
    <h5 class="text-secondary mt-5 mb-3">📌 Thông báo thường</h5>
    @foreach ($normal as $item)
      <div class="card mb-3 border-secondary">
        <div class="card-body">
          <h5 class="card-title mb-1 text-secondary">
            {{ $item->tieu_de }}
            <span class="badge bg-secondary ms-2">Thường</span>
          </h5>
          <p class="card-text text-muted small mb-2">
            Hiển thị:
            @if($item->hien_thi_tu) từ {{ \Carbon\Carbon::parse($item->hien_thi_tu)->format('d/m/Y') }} @endif
            @if($item->hien_thi_den) đến {{ \Carbon\Carbon::parse($item->hien_thi_den)->format('d/m/Y') }} @endif
          </p>
          <div class="card-text" style="white-space: pre-line;">{{ $item->noi_dung }}</div>
        </div>
      </div>
    @endforeach
  @endif

  <div class="mt-4">
    {{ $announcements->links() }}
  </div>
</div>
@endsection
