@extends('layouts.admin')

@section('content')
<div class="container py-4">
     <style>
    h3 {
      font-weight: bold;
      border-left: 6px solid #0d6efd;
      padding-left: 12px;
    }

    .btn i {
      margin-right: 5px;
    }

    .table th, .table td {
      vertical-align: middle;
      text-align: center;
    }

    .table td:first-child {
      font-weight: 600;
    }

    .badge {
      padding: 6px 12px;
      font-size: 0.85rem;
      border-radius: 20px;
    }

    .btn-sm {
      font-size: 0.85rem;
      padding: 6px 10px;
      border-radius: 6px;
    }

    .table {
      box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
      border-radius: 10px;
      overflow: hidden;
    }

    .alert {
      font-size: 0.95rem;
    }

    .btn-success i, .btn-warning i, .btn-danger i {
      margin-right: 4px;
    }
  </style>
  <h3 class="mb-4">📢 Danh sách thông báo nhân sự</h3>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <a href="{{ route('admin.announcements.create') }}" class="btn btn-success mb-3">
    <i class="bi bi-plus-circle"></i> Tạo thông báo mới
  </a>

  <table class="table table-bordered align-middle">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Tiêu đề</th>
        <th>Quan trọng</th>
        <th>Hiển thị từ</th>
        <th>Hiển thị đến</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      @foreach($announcements as $index => $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->tieu_de }}</td>
          <td>
            <span class="badge {{ $item->do_quan_trong === 'Quan trọng' ? 'bg-danger' : 'bg-secondary' }}">
              {{ $item->do_quan_trong }}
            </span>
          </td>
          <td>{{ $item->hien_thi_tu ? \Carbon\Carbon::parse($item->hien_thi_tu)->format('d/m/Y') : '-' }}</td>
          <td>{{ $item->hien_thi_den ? \Carbon\Carbon::parse($item->hien_thi_den)->format('d/m/Y') : '-' }}</td>

          <td class="d-flex gap-2">
            <a href="{{ route('admin.announcements.edit', $item->id) }}" class="btn btn-sm btn-warning">
              <i class="bi bi-pencil"></i> Sửa
            </a>
            <form action="{{ route('admin.announcements.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Xoá thông báo này?');">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">
                <i class="bi bi-trash"></i> Xoá
              </button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
