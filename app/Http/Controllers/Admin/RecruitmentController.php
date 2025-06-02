<?php

namespace App\Http\Controllers\Admin;


use App\Models\Recruitment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
class RecruitmentController extends Controller
{
    public function index()
    {
        $recruitments = Recruitment::latest()->get();
        return view('admin.recruitments.index', compact('recruitments'));
    }

    public function create()
        {
            $departments = Department::pluck('ten_phongban', 'id'); // hoặc ->all() nếu bạn cần nhiều dữ liệu
            return view('admin.recruitments.create', compact('departments'));
        }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'department' => 'nullable|string|max:100',
            'deadline' => 'nullable|date',
        ]);

        Recruitment::create($request->only('title', 'description', 'department', 'deadline'));

        return redirect()->route('admin.recruitments.index')->with('success', 'Đã đăng tin thành công!');
    }

    public function edit($id)
        {
        $recruitment = Recruitment::findOrFail($id);
        $departments = Department::pluck('ten_phongban', 'id');
        return view('admin.recruitments.edit', compact('recruitment', 'departments'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'department' => 'nullable|string|max:100',
        'deadline' => 'nullable|date',
    ]);

    $recruitment = Recruitment::findOrFail($id);
    $recruitment->update($request->only('title', 'description', 'department', 'deadline'));

    return redirect()->route('admin.recruitments.index')->with('success', 'Cập nhật thành công!');
}


    public function destroy($id)
    {
        Recruitment::findOrFail($id)->delete();
        return redirect()->route('admin.recruitments.index')->with('success', 'Đã xóa thành công!');
    }
}
