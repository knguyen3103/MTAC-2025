@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">Cập Nhật Thông Tin Cá Nhân</h2>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6">
        @csrf

      
        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label for="avatar" class="block text-sm font-medium mb-1">Avatar</label>
            <input type="file" name="avatar" id="avatar" accept="image/*" class="border rounded p-2 w-full">
            @if (optional(auth()->user()->profile)->avatar)
                <img src="{{ asset('storage/' . auth()->user()->profile->avatar) }}" class="w-20 h-20 rounded-full mt-2" alt="Avatar hiện tại">
            @endif
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium mb-1">Điện thoại</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', optional(auth()->user()->profile)->phone) }}" class="border rounded p-2 w-full">
        </div>

        <div class="mb-4">
            <label for="address" class="block text-sm font-medium mb-1">Địa chỉ</label>
            <input type="text" name="address" id="address" value="{{ old('address', optional(auth()->user()->profile)->address) }}" class="border rounded p-2 w-full">
        </div>

        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Lưu thay đổi</button>
    </form>
</div>
@endsection
