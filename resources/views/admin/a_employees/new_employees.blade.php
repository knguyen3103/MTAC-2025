@extends('layouts.admin')

@section('content')
<style>
  .container h3 {
    font-size: 1.5rem;
    font-weight: bold;
    border-left: 6px solid #198754;
    padding-left: 12px;
    margin-bottom: 1.5rem;
  }

  .table th, .table td {
    text-align: center;
    vertical-align: middle;
  }

  .badge-success {
    background-color: #198754;
    color: #fff;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
  }

  .action-buttons {
    margin-bottom: 20px;
  }

  .btn-group-sm .btn {
    padding: 5px 8px;
    font-size: 0.8rem;
  }
</style>

<div class="container py-4">
  <h3>🆕 Danh sách nhân viên mới (Ứng viên đủ hồ sơ)</h3>

  {{-- Nút quay lại --}}
  <div class="action-buttons d-flex gap-2 mb-3">
    <a href="{{ route('admin.a_employees.index') }}" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left-circle"></i> Quay lại danh sách nhân sự
    </a>
    <a href="{{ route('admin.hr.index') }}" class="btn btn-outline-primary">
      <i class="bi bi-folder-check"></i> Quản lý hồ sơ nhân sự
    </a>
  </div>

  @if($employees->count())
  <div class="table-responsive shadow rounded">
    <table class="table table-bordered table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Họ tên</th>
          <th>Email</th>
          <th>Vị trí</th>
          <th>Trạng thái</th>
          <th>Hồ sơ</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        @foreach($employees as $index => $emp)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $emp->full_name }}</td>
          <td>{{ $emp->email }}</td>
          <td>{{ $emp->position ?? '-' }}</td>
          <td><span class="badge bg-success">{{ $emp->status }}</span></td>
          <td>{{ $emp->hr_file_status }}</td>
          <td class="d-flex justify-content-center gap-1 flex-wrap">
            <a href="{{ route('admin.applicants.show', $emp->id) }}" class="btn btn-sm btn-info">
              <i class="bi bi-eye"></i> Xem
            </a>
            <form action="{{ route('admin.applicants.approve') }}" method="POST" onsubmit="return confirm('Xét duyệt thành Chính thức?')">
              @csrf
              <input type="hidden" name="applicant_id" value="{{ $emp->id }}">
              <input type="hidden" name="trang_thai" value="Chính thức">
              <button class="btn btn-sm btn-success" type="submit">
                <i class="bi bi-person-check"></i> Chính thức
              </button>
            </form>
            <form action="{{ route('admin.applicants.approve') }}" method="POST" onsubmit="return confirm('Xét duyệt thành Thử việc?')">
              @csrf
              <input type="hidden" name="applicant_id" value="{{ $emp->id }}">
              <input type="hidden" name="trang_thai" value="Thử việc">
              <button class="btn btn-sm btn-warning" type="submit">
                <i class="bi bi-person-lines-fill"></i> Thử việc
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @else
  <div class="alert alert-warning mt-4 text-center">
    <i class="bi bi-exclamation-circle"></i> Chưa có ứng viên nào đủ hồ sơ.
  </div>
  @endif
</div>
@endsection
