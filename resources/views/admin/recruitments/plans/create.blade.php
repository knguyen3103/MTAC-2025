@extends('layouts.admin')

@section('content')
<!-- FontAwesome nếu chưa có -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
.container {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    max-width: 1000px;
}
h3.text-success {
    font-size: 1.6rem;
    border-left: 6px solid #28a745;
    padding-left: 12px;
    margin-bottom: 24px;
}
.form-label {
    font-weight: 600;
    margin-bottom: 6px;
}
.form-select,
.form-control {
    font-size: 0.95rem;
    padding: 8px 12px;
    border-radius: 8px;
}
small.text-muted {
    font-size: 0.8rem;
    margin-top: 4px;
    display: inline-block;
}
.btn {
    padding: 8px 16px;
    font-size: 0.95rem;
    border-radius: 8px;
}
.btn i {
    margin-right: 6px;
}
.row > div {
    margin-bottom: 16px;
}
@media (max-width: 768px) {
    .container {
        padding: 16px;
    }
    h3.text-success {
        font-size: 1.3rem;
    }
}
</style>

<div class="container mt-4">
    <h3 class="mb-4 text-success fw-bold">➕ Thêm kế hoạch tuyển dụng</h3>

    <form action="{{ route('admin.recruitments.plans.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Khu vực</label>
                <select name="area" class="form-select" required>
                    <option value="">-- Chọn khu vực --</option>
                    <option value="Thành phố Hồ Chí Minh">Thành phố Hồ Chí Minh</option>
                    <option value="Thừa Thiên Huế">Thừa Thiên Huế</option>
                    <option value="Tiền Giang">Tiền Giang</option>
                    <option value="Bến Tre">Bến Tre</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Loại</label>
                <select name="department_type" class="form-select" required>
                    <option value="">-- Phòng ban hoặc khác --</option>
                    <option value="Phòng ban">Phòng ban</option>
                    <option value="Khác">Khác</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Phòng ban cụ thể</label>
               <select name="department_id" class="form-select">
                <option value="">-- Chọn phòng ban cụ thể --</option>
                @foreach($departments as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Năm</label>
                <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>
            </div>

            <div class="col-md-2">
                <label class="form-label">Tháng</label>
                <select name="month" class="form-select" required>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">Tháng {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Số lượng</label>
                <input type="number" name="quantity" min="0" class="form-control" required>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Lưu kế hoạch
            </button>
            <a href="{{ route('admin.recruitments.plans.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </form>
</div>
@endsection
