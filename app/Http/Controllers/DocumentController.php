<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse; // ← sửa import

class DocumentController extends Controller
{
    /**
     * Áp dụng middleware auth cho toàn bộ controller.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Hiển thị danh sách tài liệu của user.
     */
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $docs = $user
            ->documents()  // giờ IDE hiểu $user là User
            ->latest()
            ->paginate(10);

        return view('documents.index', compact('docs'));
    }

    /**
     * Form upload tài liệu mới.
     */
    public function create(): View
    {
        return view('documents.create');
    }

    /**
     * Xử lý upload và lưu vào CSDL.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'file'  => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:2048',
        ]);

        $file = $data['file'];
        $path = $file->store('documents', 'public');

        Document::create([
            'user_id'   => Auth::id(),
            'title'     => $data['title'],
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size'      => $file->getSize(),
        ]);

        return redirect()
            ->route('documents.index')
            ->with('success', 'Upload thành công!');
    }

    /**
     * Download tài liệu (chỉ user chủ sở hữu).
     *
     * @param  Document  $document
     * @return BinaryFileResponse
     */
    public function download(Document $document): BinaryFileResponse
{
    if (Auth::id() !== $document->user_id) {
        abort(403);
    }

    /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
    $disk = Storage::disk('public');

    $fullPath = $disk->path($document->file_path);  // ← now Intelephense knows `path()`

    return response()->download($fullPath, $document->title);
}

    /**
     * Xoá tài liệu (chỉ user chủ sở hữu).
     */
    public function destroy(Document $document): RedirectResponse
    {
        if (Auth::id() !== $document->user_id) {
            abort(403);
        }

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Xoá tài liệu thành công.');
    }
}
