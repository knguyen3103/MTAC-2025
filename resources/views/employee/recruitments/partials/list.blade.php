@forelse ($recruitments as $item)
  <div class="card mb-3 card-recruitment">
    <div class="card-body">
      <h5 class="card-title">{{ $item->title }}</h5>
      @if ($item->department)
        <p class="mb-1 text-muted small">Phòng ban: {{ $item->department->ten_phongban }}</p>
      @endif
      @if ($item->deadline)
        <p class="mb-1 text-muted small">Hạn nộp: {{ \Carbon\Carbon::parse($item->deadline)->format('d/m/Y') }}</p>
      @endif

      <p class="card-text mt-2">
        {{ \Illuminate\Support\Str::limit(strip_tags($item->description), 100) }}
      </p>

      <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#recruitmentModal{{ $item->id }}">
        Xem chi tiết
      </button>
    </div>
  </div>

  <!-- Modal chi tiết -->
  <div class="modal fade" id="recruitmentModal{{ $item->id }}" tabindex="-1" aria-labelledby="recruitmentModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="recruitmentModalLabel{{ $item->id }}">{{ $item->title }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>
        <div class="modal-body">
          @if ($item->department)
            <p><strong>Phòng ban:</strong> {{ $item->department->ten_phongban }}</p>
          @endif
          @if ($item->deadline)
            <p><strong>Hạn nộp:</strong> {{ \Carbon\Carbon::parse($item->deadline)->format('d/m/Y') }}</p>
          @endif
          <hr>
          <div style="white-space: pre-line;">{!! $item->description !!}</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        </div>
      </div>
    </div>
  </div>
@empty
  <div class="alert alert-warning">Không tìm thấy kết quả phù hợp.</div>
@endforelse

@if ($recruitments->hasPages())
  <div class="mt-4 d-flex justify-content-center">
    {{-- Dùng pagination Bootstrap chính xác --}}
    {!! $recruitments->appends(request()->query())->links('pagination::bootstrap-5') !!}
  </div>
@endif
