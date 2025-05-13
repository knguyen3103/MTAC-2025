<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    public function index()
    {
        // Tạm thời trả về view danh sách tuyển dụng
        return view('admin.recruitments.index');
    }
}
