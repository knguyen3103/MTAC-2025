<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Applicant;
use App\Models\Interview;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Tổng số nhân viên chính thức (bao gồm tất cả trạng thái)
        $totalEmployees = Employee::count();

        // 2. Số thư mời đã gửi trong tháng hiện tại
        $invitationCountThisMonth = Interview::whereMonth('created_at', now()->month)->count();

        // 3. Tổng số ứng viên
        $totalApplicants = Applicant::count();

        // 4. Tổng số thực tập sinh (trạng thái = "Thực tập")
        $internsCount = Employee::where('trang_thai', 'Thực tập')->count();

        // 5. Danh sách nhân viên mới nhất (từ ứng viên đã trúng tuyển và đủ hồ sơ)
        $newEmployees = Employee::with('department')
            ->where('trang_thai', 'Thử việc')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // 6. 5 thông báo mới nhất
        $recentAnnouncements = Announcement::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalEmployees',
            'invitationCountThisMonth',
            'totalApplicants',
            'internsCount',
            'newEmployees',
            'recentAnnouncements'
        ));
    }
}
