<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;

class ReportController extends Controller
{
    public function index()
    {
        $total = Employee::count();
        $byStatus = Employee::selectRaw('trang_thai, COUNT(*) as total')->groupBy('trang_thai')->pluck('total', 'trang_thai');
        $departments = Department::withCount('employees')->get();

        return view('admin.reports.index', compact('total', 'byStatus', 'departments'));
    }

    public function export(Request $request)
    {
        return Excel::download(new EmployeesExport, 'nhan_su.xlsx');
    }
}
