<?php

namespace App\Http\Controllers\Admin;


use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
   
    public function index()
    {
        $departments = Department::all();
        return view('admin.departments.index', compact('departments'));
    }

    
    public function create()
    {
        return view('admin.departments.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'ten_phongban' => 'required|string|max:255',
            'ma_phongban' => 'required|string|max:50|unique:departments',
        ]);

        Department::create($request->only('ten_phongban', 'ma_phongban'));

        return redirect()->route('admin.departments.index')->with('success', 'Đã thêm phòng ban thành công');
    }

    
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'ten_phongban' => 'required|string|max:255',
            'ma_phongban' => 'required|string|max:50|unique:departments,ma_phongban,' . $department->id,
        ]);

        $department->update($request->only('ten_phongban', 'ma_phongban'));

        return redirect()->route('admin.departments.index')->with('success', 'Cập nhật phòng ban thành công');
    }

    
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Đã xoá phòng ban');
    }
}
