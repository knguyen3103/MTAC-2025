<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Department;
class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
    $announcements = Announcement::latest()->paginate(10);
    return view('admin.announcements.index', compact('announcements'));
}

public function create() {
    $departments = Department::all();
    return view('admin.announcements.create', compact('departments'));
}

public function store(Request $request) {
        $request->validate([
        'tieu_de' => 'required|string|max:255',
        'noi_dung' => 'required|string',
        'do_quan_trong' => 'required|in:Thường,Quan trọng',
        'hien_thi_tu' => 'nullable|date',
        'hien_thi_den' => 'nullable|date|after_or_equal:hien_thi_tu',
        'department_id' => 'nullable|exists:departments,id',
    ]);

    Announcement::create($request->all());

    return redirect()->route('admin.announcements.index')->with('success', 'Đã tạo thông báo.');
}
public function edit($id) {
    $announcement = Announcement::findOrFail($id);
    $departments = Department::all();
    return view('admin.announcements.edit', compact('announcement', 'departments'));
}
public function update(Request $request, $id) {
    $request->validate([
        'tieu_de' => 'required|string|max:255',
        'noi_dung' => 'required|string',
        'do_quan_trong' => 'required|in:Thường,Quan trọng',
        'hien_thi_tu' => 'nullable|date',
        'hien_thi_den' => 'nullable|date|after_or_equal:hien_thi_tu',
        'department_id' => 'nullable|exists:departments,id',
    ]);

    $announcement = Announcement::findOrFail($id);
    $announcement->update($request->only([
        'tieu_de', 'noi_dung', 'do_quan_trong', 'hien_thi_tu', 'hien_thi_den', 'department_id'
    ]));

    return redirect()->route('admin.announcements.index')->with('success', 'Đã cập nhật thông báo.');
}
public function destroy($id)
    {
        $announcement = \App\Models\Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', '🗑️ Đã xóa thông báo thành công.');
    }



}
