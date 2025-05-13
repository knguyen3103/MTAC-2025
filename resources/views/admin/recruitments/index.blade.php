@extends('layouts.admin')

@section('content')
<div class="p-8 bg-gray-100 min-h-screen">
    <h1 class="text-2xl font-semibold mb-4">📄 Danh sách đợt tuyển dụng</h1>

    <div class="bg-white p-6 rounded shadow">
        <p class="text-gray-600">Tạm thời chưa có dữ liệu tuyển dụng. Bạn có thể tạo mới.</p>
        <a href="{{ route('admin.recruitments.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            ➕ Tạo đợt tuyển dụng mới
        </a>
    </div>
</div>
@endsection
