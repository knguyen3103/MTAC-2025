@extends('layouts.admin')

@section('content')
@php use Illuminate\Support\Str; @endphp
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
  .section-header { font-size: 2rem; font-weight: 700; margin-bottom: 1.5rem; }
  .stat-box {
    background-color: #fff;
    border-radius: 1rem;
    padding: 1.25rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    border-left: 6px solid;
    transition: all 0.3s ease;
  }
  .stat-title { font-size: 0.875rem; color: #6c757d; margin-bottom: 0.25rem; }
  .stat-value { font-size: 1.5rem; font-weight: bold; color: #000; }

  .section-box {
    background-color: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
    padding: 1.5rem;
    margin-bottom: 2rem;
  }
</style>

<div class="min-vh-100 p-4 bg-white text-dark">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="section-header">🎯 Trang dành cho Admin !</h1>
    <span class="text-muted">{{ now()->format('d/m/Y H:i') }}</span>
  </div>

  {{-- Thống kê nhanh --}}
  <h5 class="mb-3">📌 Thống kê nhân sự</h5>
  <div class="row g-4 mb-5">
    @foreach([
      ['label' => 'Tổng nhân viên', 'value' => $totalEmployees ?? '...', 'color' => '#4f46e5'],
      ['label' => 'Thư mời đã gửi trong tháng', 'value' => $invitationCountThisMonth ?? '...', 'color' => '#0ea5e9'],
      ['label' => 'Ứng viên', 'value' => $totalApplicants ?? '...', 'color' => '#10b981'],
      ['label' => 'Thực tập sinh', 'value' => $internsCount ?? '...', 'color' => '#f97316'],
    ] as $stat)
    <div class="col-6 col-md-4 col-xl-3">
      <div class="stat-box" style="border-left-color: {{ $stat['color'] }};">
        <div class="stat-title">{{ $stat['label'] }}</div>
        <div class="stat-value">{{ $stat['value'] }}</div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Thông báo nội bộ --}}
  <div class="section-box">
    <h5 class="mb-3">📢 Thông báo nội bộ</h5>
    @forelse($recentAnnouncements ?? [] as $news)
      <div class="py-2 border-bottom">
        <a href="{{ route('admin.announcements.edit', $news->id) }}" class="text-dark fw-semibold d-block">
          📌 {{ $news->tieu_de }}
        </a>
        <div class="text-muted small mb-1">
          {{ $news->created_at->format('d/m/Y') }} &bull; {{ Str::limit(strip_tags($news->noi_dung), 100) }}
        </div>
      </div>
    @empty
      <p class="text-muted">Chưa có thông báo nào.</p>
    @endforelse
  </div>

  {{-- Nhân viên mới --}}
  <div class="section-box overflow-auto">
    <h5 class="mb-3">👤 Nhân viên mới nhất</h5>
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>Họ tên</th>
          <th>Phòng ban</th>
          <th>Ngày vào</th>
        </tr>
      </thead>
      <tbody>
        @forelse($newEmployees ?? [] as $nv)
        <tr>
          <td>{{ $nv->full_name }}</td>
          <td>{{ $nv->department->ten_phongban ?? '-' }}</td>
          <td>{{ $nv->updated_at->format('d/m/Y') }}</td>
        </tr>
        @empty
        <tr><td colspan="3" class="text-muted">Không có dữ liệu.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
