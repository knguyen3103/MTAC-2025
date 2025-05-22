@extends('layouts.admin')

@section('content')
<div class="container">
  <h3>Thêm phòng ban</h3>


  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.departments.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="ten_phongban" class="form-label">Tên phòng ban</label>
      <input type="text" name="ten_phongban" class="form-control @error('ten_phongban') is-invalid @enderror"
             value="{{ old('ten_phongban') }}" required>
      @error('ten_phongban')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="ma_phongban" class="form-label">Mã phòng ban</label>
      <input type="text" name="ma_phongban" class="form-control @error('ma_phongban') is-invalid @enderror"
             value="{{ old('ma_phongban') }}" required>
      @error('ma_phongban')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Lưu</button>
    <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">Quay lại</a>
  </form>
</div>
@endsection
