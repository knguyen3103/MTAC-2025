@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">Upload Tài liệu mới</h2>
    @if($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label for="title" class="block mb-1 font-medium">Tiêu đề</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="border rounded p-2 w-full">
        </div>
        <div class="mb-4">
            <label for="file" class="block mb-1 font-medium">Chọn file</label>
            <input type="file" name="file" id="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png" class="border rounded p-2 w-full">
        </div>
        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Upload</button>
    </form>
</div>
@endsection