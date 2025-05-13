@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">Tài liệu của tôi</h2>
    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif
    <a href="{{ route('documents.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded">Upload mới</a>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4">Tiêu đề</th>
                <th class="py-2 px-4">Kích thước (KB)</th>
                <th class="py-2 px-4">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($docs as $doc)
            <tr class="border-t">
                <td class="py-2 px-4">{{ $doc->title }}</td>
                <td class="py-2 px-4">{{ round($doc->size/1024, 2) }}</td>
                <td class="py-2 px-4">
                    <a href="{{ route('documents.download', $doc) }}" class="mr-2">Tải về</a>
                    <form action="{{ route('documents.destroy', $doc) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Chắc chắn xoá?')">Xoá</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $docs->links() }}
</div>
@endsection