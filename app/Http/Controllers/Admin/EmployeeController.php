<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Models\Applicant;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('department');

        // Lọc theo loại nhân sự
        if ($request->loai === 'noi_bo') {
            $query->whereHas('department', fn($q) => $q->where('loai', 'noi_bo'));
        } elseif ($request->loai === 'ben_ngoai') {
            $query->whereHas('department', fn($q) => $q->where('loai', 'ben_ngoai'));
        }

        // Lọc theo trạng thái
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // Tìm kiếm theo tên hoặc mã NV
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('ma_nhanvien', 'like', "%$keyword%")
                  ->orWhere('ho_ten', 'like', "%$keyword%");
            });
        }

        $employees = $query->paginate(10)->withQueryString();

        return view('admin.a_employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.a_employees.create', compact('departments'));
    }

   public function store(Request $request)
{
    $request->validate([
        'ho_ten'        => 'required|string|max:255',
        'gioi_tinh'     => 'required|string',
        'ngay_sinh'     => 'nullable|date',
        'department_id' => 'required|exists:departments,id',
        'vi_tri'        => 'nullable|string|max:255',
        'trang_thai'    => 'required|string',
    ]);

    // Ánh xạ trạng thái → tiền tố mã nhân viên
    $prefixMap = [
        'Chính thức'     => 'MT',
        'Thử việc'       => 'MTN',
        'Đào tạo'        => 'DT',
        'Thực tập'       => 'TT',
        'Cộng tác viên'  => 'TV',
        'Thời vụ'        => 'TVU',
    ];

    $prefix = $prefixMap[$request->trang_thai] ?? 'NV';
    $count = Employee::where('ma_nhanvien', 'like', $prefix . '%')->count() + 1;
    $ma_nhanvien = $prefix . str_pad($count, 2, '0', STR_PAD_LEFT);

    Employee::create([
        'ma_nhanvien'   => $ma_nhanvien,
        'ho_ten'        => $request->ho_ten,
        'gioi_tinh'     => $request->gioi_tinh,
        'ngay_sinh'     => $request->ngay_sinh,
        'vi_tri'        => $request->vi_tri,
        'trang_thai'    => $request->trang_thai,
        'department_id' => $request->department_id,
        'email'         => null // hoặc bổ sung nếu cần
    ]);

    return redirect()->route('admin.a_employees.index')->with('success', "✅ Đã thêm nhân sự {$ma_nhanvien} thành công.");
}

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();

        return view('admin.a_employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'ma_nhanvien'   => 'required|string|max:50|unique:employees,ma_nhanvien,' . $employee->id,
            'ho_ten'        => 'required|string|max:255',
            'gioi_tinh'     => 'required|string',
            'ngay_sinh'     => 'nullable|date',
            'department_id' => 'required|exists:departments,id',
            'vi_tri'        => 'nullable|string|max:255',
            'trang_thai'    => 'required|string',
        ]);

        $employee->update($request->only([
            'ma_nhanvien', 'ho_ten', 'gioi_tinh', 'ngay_sinh',
            'so_dien_thoai', 'email', 'vi_tri', 'chuc_vu',
            'department_id', 'trang_thai'
        ]));


        return redirect()->route('admin.a_employees.index')->with('success', 'Cập nhật nhân sự thành công.');
    }

    public function show($id)
    {
        $employee = Employee::with('department')->findOrFail($id);
        return view('admin.a_employees.show', compact('employee'));
    }
    // Danh sách nhân viên mới (ứng viên đã đủ hồ sơ)
public function newEmployees()
    {
        $employees = Applicant::where('hr_file_status', 'Đủ HS')
                            ->where('status', 'Trúng tuyển') // đảm bảo đúng logic
                            ->orderByDesc('updated_at')
                            ->get();

       return view('admin.a_employees.new_employees', compact('employees'));

    }

}
