<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Recruitment;
use App\Models\Department;
use Illuminate\Http\Request;

class RecruitmentController extends Controller
    {
    public function index(Request $request)
    {
        $query = Recruitment::with('department')->latest();

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $recruitments = $query->paginate(5);
        $departments = Department::pluck('ten_phongban', 'id');

        // Trả HTML nếu là request AJAX
        if ($request->ajax()) {
            return view('employee.recruitments.partials.list', compact('recruitments'))->render();
        }

        return view('employee.recruitments.index', compact('recruitments', 'departments'));
    }



}

