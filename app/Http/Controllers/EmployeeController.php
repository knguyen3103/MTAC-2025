<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        // Trả về view danh sách nhân viên
        return view('admin.employees.index');
    }
}
