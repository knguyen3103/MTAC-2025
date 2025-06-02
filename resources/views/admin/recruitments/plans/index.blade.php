@extends('layouts.admin')

@section('content')
@push('styles')
<!-- FontAwesome Icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

<style>
.container {
    background: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
h3.text-primary {
    font-size: 1.6rem;
    border-left: 6px solid #086db5;
    padding-left: 12px;
    margin-bottom: 24px;
}
form select.form-select {
    min-width: 160px;
    font-size: 0.9rem;
}
.btn-success {
    font-size: 0.9rem;
    padding: 8px 14px;
    border-radius: 8px;
}
.table {
    font-size: 0.9rem;
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}
.table th,
.table td {
    vertical-align: middle;
    text-align: center;
    padding: 10px;
}
.table thead th {
    background-color: #e9f4ff !important;
    color: #004085;
    font-weight: 600;
}
.table tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}
.btn-sm {
    margin: 2px;
    padding: 6px 10px;
    font-size: 0.8rem;
    border-radius: 6px;
}
.btn-outline-success {
    font-size: 0.85rem;
    padding: 6px 12px;
    border-radius: 8px;
}
.btn-outline-success i {
    margin-right: 4px;
}
@media (max-width: 768px) {
    .container {
        padding: 12px;
    }
    h3.text-primary {
        font-size: 1.3rem;
    }
    .table {
        font-size: 0.8rem;
    }
}
</style>

<div class="container mt-4">
    <h3 class="mb-4 text-primary fw-bold">📋 Kế hoạch tuyển dụng</h3>

    <div class="row mb-3">
        <div class="col-md-3">
            <form method="GET" action="" class="d-flex">
                <select name="year" class="form-select me-2" onchange="this.form.submit()">
                    @for ($y = date('Y') - 2; $y <= date('Y') + 1; $y++)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
        </div>
        <div class="col-md-4">
                <select name="area" class="form-select me-2" onchange="this.form.submit()">
                    <option value="">-- Tất cả khu vực --</option>
                    <option value="Thành phố Hồ Chí Minh" {{ request('area') == 'Thành phố Hồ Chí Minh' ? 'selected' : '' }}>Thành phố Hồ Chí Minh</option>
                    <option value="Thừa Thiên Huế" {{ request('area') == 'Thừa Thiên Huế' ? 'selected' : '' }}>Thừa Thiên Huế</option>
                    <option value="Tiền Giang" {{ request('area') == 'Tiền Giang' ? 'selected' : '' }}>Tiền Giang</option>
                    <option value="Bến Tre" {{ request('area') == 'Bến Tre' ? 'selected' : '' }}>Bến Tre</option>
                </select>
            </form>
        </div>

        <div class="col-md-3 text-end">
            <a href="{{ route('admin.recruitments.plans.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm kế hoạch mới
            </a>
        </div>
    </div>

    <div class="text-end mb-2">
        <a href="{{ route('admin.recruitments.plans.export') }}" class="btn btn-outline-success" title="Xuất Excel">
            <i class="fas fa-file-excel"></i> Xuất Excel
        </a>
    </div>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th rowspan="2">Khu vực</th>
                <th rowspan="2">Loại</th>
                <th rowspan="2">Phòng ban</th>
                <th colspan="5">Năm {{ request('year', now()->year) }}</th>
                <th rowspan="2">Thao tác</th>
            </tr>
            <tr>
                <th>Tháng 1</th>
                <th>Tháng 2</th>
                <th>Tháng 3</th>
                <th>Tháng 4</th>
                <th>Tháng 5</th>
            </tr>
        </thead>
        <tbody>
            @forelse($plans as $area => $deptGroups)
                @foreach($deptGroups as $type => $items)
                    @php $firstItem = $items->first(); @endphp
                    <tr>
                        <td>{{ $area }}</td>
                        <td>{{ $type }}</td>
                        <td>{{ $firstItem->department->ten_phongban ?? '—' }}</td>
                        @for ($m = 1; $m <= 5; $m++)
                            @php $monthPlan = $items->firstWhere('month', $m); @endphp
                            <td>{{ $monthPlan ? $monthPlan->quantity : '—' }}</td>
                        @endfor
                        <td>
                            <a href="{{ route('admin.recruitments.plans.edit', $firstItem->id) }}"
                               class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.recruitments.plans.destroy', $firstItem->id) }}"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Xóa kế hoạch này?')"
                                        title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="9">Không có dữ liệu kế hoạch.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
