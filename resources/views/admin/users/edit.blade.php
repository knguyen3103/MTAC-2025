@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">✏️ Chỉnh sửa tài khoản</h3>

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="card shadow p-4 bg-white rounded">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tên đăng nhập</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phân quyền</label>
            <select name="role_id" class="form-select">
                <option value="">-- Chưa phân quyền --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="text-end">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
    </form>
</div>
@endsection
