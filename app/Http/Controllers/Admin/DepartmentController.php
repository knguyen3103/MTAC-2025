<?php

namespace App\Http\Controllers\Admin;


use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
class DepartmentController extends Controller
{
   
    public function index()
        {
            $departments = Department::withCount('employees')->paginate(10); // hoặc 20 tuỳ bạn
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

    
   public function edit($id)
{
    $department = Department::findOrFail($id);
    return view('admin.departments.edit', compact('department'));
}


    
   public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'ten_phongban' => 'required|string|max:255',
            'ma_phongban' => 'required|string|max:50|unique:departments,ma_phongban,' . $department->id,
        ]);

        $department->update($request->only('ten_phongban', 'ma_phongban'));

        return redirect()->route('admin.departments.index')->with('success', 'Cập nhật phòng ban thành công');
    }

    
    public function destroy($id)
        {
            $department = Department::findOrFail($id);
            $department->delete();

            return redirect()->route('admin.departments.index')->with('success', 'Đã xoá phòng ban');
        }
    public function employees($id)
        {
            $department = Department::with('employees')->findOrFail($id);
            $employees = $department->employees()->paginate(10);

            return view('admin.departments.employees', compact('department', 'employees'));
        }


}
