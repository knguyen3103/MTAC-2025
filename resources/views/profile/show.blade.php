@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">Thông Tin Cá Nhân</h2>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center">
            <img src="{{ auth()->user()->profile->avatar ? asset('storage/' . auth()->user()->profile->avatar) : asset('images/default-avatar.png') }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover mr-4">
            <div>
                <p><strong>Họ và tên:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Điện thoại:</strong> {{ auth()->user()->profile->phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ auth()->user()->profile->address }}</p>
            </div>
        </div>
        <a href="{{ route('profile.edit') }}" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded">Chỉnh sửa</a>
    </div>
</div>
@endsection