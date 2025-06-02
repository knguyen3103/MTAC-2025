<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
class ApplicantController extends Controller
{
   public function index(Request $request)
        {
            $status = $request->query('status');
            $query = Applicant::query();

            // Chỉ hiển thị ứng viên chưa trúng tuyển (ẩn ứng viên đã chuyển sang mục hồ sơ)
            $query->where('status', '!=', 'Trúng tuyển');

            // Nếu có bộ lọc trạng thái riêng, vẫn cho phép
            if ($status) {
                $query->where('status', $status);
            }

            $applicants = $query->get();
            return view('admin.applicants.index', compact('applicants', 'status'));
        }

    public function create()
    {
        return view('admin.applicants.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'   => 'required',
            'email'       => 'required|email|unique:applicants,email',
            'cv_file'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'birthday'    => 'nullable|date',
            'major'       => 'nullable|string|max:255',
            'university'  => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'full_name', 'email', 'phone', 'birthday', 'major', 'university',
            'position', 'status'
        ]);

        // Gán mặc định là "Chờ duyệt" nếu không chọn
        $data['status'] = $data['status'] ?? 'Chờ duyệt';

        if ($request->hasFile('cv_file')) {
            $data['cv_path'] = $request->file('cv_file')->store('cv', 'public');
        }

        Applicant::create($data);
        return redirect()->route('admin.applicants.index')->with('success', 'Đã thêm ứng viên');
    }

    public function edit($id)
    {
        $applicant = Applicant::findOrFail($id);
        return view('admin.applicants.form', compact('applicant'));
    }

    public function update(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);

        $request->validate([
            'full_name'   => 'required',
            'email'       => 'required|email|unique:applicants,email,' . $id,
            'cv_file'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'birthday'    => 'nullable|date',
            'major'       => 'nullable|string|max:255',
            'university'  => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'full_name', 'email', 'phone', 'birthday', 'major', 'university',
            'position', 'status'
        ]);

        if ($request->hasFile('cv_file')) {
            if ($applicant->cv_path) {
                Storage::disk('public')->delete($applicant->cv_path);
            }
            $data['cv_path'] = $request->file('cv_file')->store('cv', 'public');
        }

        $applicant->update($data);
        return redirect()->route('admin.applicants.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $applicant = Applicant::findOrFail($id);

        if ($applicant->cv_path) {
            Storage::disk('public')->delete($applicant->cv_path);
        }

        $applicant->delete();
        return redirect()->route('admin.applicants.index')->with('success', 'Đã xóa');
    }

    // Lọc danh sách ứng viên đã duyệt hoặc loại
    public function approved(Request $request)
    {
        $status = $request->query('status');
        $query = Applicant::query();

        if ($status) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['Đã duyệt', 'Loại']);
        }

        $applicants = $query->get();
        return view('admin.applicants.approved', compact('applicants', 'status'));
    }

    // Danh sách ứng viên đã xác nhận đồng ý tuyển
    public function accepted()
    {
        $applicants = Applicant::where('status', 'Đã duyệt')
                               ->where('confirmation', 'Đã đồng ý')
                               ->get();
        return view('admin.applicants.accepted', compact('applicants'));
    }

    // Cập nhật phản hồi xác nhận hồ sơ (Trúng tuyển)
    public function confirm(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->confirmation = $request->input('confirmation');
        $applicant->save();

        return redirect()->route('admin.applicants.accepted')->with('success', 'Đã cập nhật xác nhận hồ sơ.');
    }

    // Cập nhật trạng thái hồ sơ nhân sự
    public function updateHRFileStatus(Request $request, $id)
        {
            $request->validate([
                'hr_file_status' => 'nullable|string|max:255'
            ]);

            $applicant = Applicant::findOrFail($id);
            $status = $request->input('hr_file_status');

            $applicant->hr_file_status = $status;

            // ✅ Logic cập nhật trạng thái tuyển dụng tương ứng
            if ($status === 'Đủ HS') {
                $applicant->status = 'Trúng tuyển';
            } else {
                $applicant->status = 'Đang xét duyệt';
            }

            $applicant->save();

            return redirect()->back()->with('success', '✅ Đã cập nhật trạng thái hồ sơ nhân sự.');
        }

    // Danh sách có trạng thái hồ sơ nhân sự
    public function hrFileStatus()
    {
        $applicants = Applicant::whereNotNull('hr_file_status')->get();
        return view('admin.applicants.hr', compact('applicants'));
    }

    // Chuyển sang phòng HCNS khi ứng viên đã xác nhận đồng ý
    public function moveToHR($id)
    {
        $applicant = Applicant::findOrFail($id);

        if ($applicant->confirmation === 'Đã đồng ý') {
            $applicant->hr_file_status = 'Chưa nhận';
            $applicant->save();

            return redirect()->back()->with('success', '✅ Đã chuyển ứng viên sang phòng HCNS.');
        }

        return redirect()->back()->with('error', '❌ Ứng viên chưa xác nhận "Đã đồng ý".');
    }

    // Xóa trạng thái hồ sơ nhân sự
    public function removeHRFileStatus($id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->hr_file_status = null;
        $applicant->save();

        return redirect()->back()->with('success', '🗑️ Đã xóa trạng thái hồ sơ nhân sự.');
    }

    // Thống kê ứng viên theo trạng thái
    public function statistics()
    {
        $totalApplicants = Applicant::count();
        $pending  = Applicant::where('status', 'Chờ duyệt')->count();
        $approved = Applicant::where('status', 'Đã duyệt')->count();
        $rejected = Applicant::where('status', 'Loại')->count();

        $confirmed = Applicant::where('confirmation', 'Đã đồng ý')->count();
        $unconfirmed = Applicant::where('confirmation', 'Không đồng ý')->count();
        $other = Applicant::whereNotIn('confirmation', ['Đã đồng ý', 'Không đồng ý'])
                        ->whereNotNull('confirmation')->count();

        return view('admin.applicants.statistics', compact(
            'totalApplicants', 'pending', 'approved', 'rejected',
            'confirmed', 'unconfirmed', 'other'
        ));
    }


    // Cập nhật lịch và xác nhận phỏng vấn
    public function updateInterviewStatus(Request $request, $id)
    {
        $request->validate([
            'schedule_status' => 'nullable|string|max:255',
            'confirmation' => 'nullable|string|max:255',
        ]);

        $applicant = Applicant::findOrFail($id);
        $applicant->schedule_status = $request->schedule_status;
        $applicant->confirmation = $request->confirmation;
        $applicant->save();

        return redirect()->back()->with('success', 'Đã cập nhật lịch và xác nhận phỏng vấn.');
    }
    public function newEmployees()
        {
            $employees = \App\Models\Applicant::where('hr_file_status', 'Đủ HS')
                ->where('status', 'Trúng tuyển')
                ->orderByDesc('updated_at')
                ->get();

            return view('admin.a_employees.new_employees', compact('employees'));
        }

     public function approve(Request $request)
    {
        $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'trang_thai'   => 'required|string|max:50',
        ]);

        $applicant = Applicant::findOrFail($request->applicant_id);

        // Map trạng thái sang tiền tố mã nhân viên
        $prefixMap = [
            'Chính thức'     => 'MT',
            'Thử việc'       => 'MTN',
            'Đào tạo'        => 'DT',
            'Thực tập'       => 'TT',
            'Cộng tác viên'  => 'TV',
            'Thời vụ'        => 'TVU',
        ];

        $prefix = $prefixMap[$request->trang_thai] ?? 'NV';

        // Đếm số nhân viên cùng tiền tố để sinh mã tiếp theo
        $count = Employee::where('ma_nhanvien', 'like', $prefix . '%')->count() + 1;
        $ma_nhanvien = $prefix . str_pad($count, 2, '0', STR_PAD_LEFT);

        $departmentId = Department::inRandomOrder()->value('id') ?? 1;

        Employee::create([
            'ma_nhanvien'   => $ma_nhanvien,
            'ho_ten'        => $applicant->full_name,
            'email'         => $applicant->email,
            'gioi_tinh'     => 'Khác',
            'vi_tri'        => $applicant->position,
            'trang_thai'    => $request->trang_thai,
            'department_id' => $departmentId,
        ]);

        $applicant->update(['status' => 'Đã chuyển nhân sự']);

        return redirect()->route('admin.a_employees.index')
            ->with('success', "✅ Đã tạo nhân sự {$ma_nhanvien} thành công.");
    }
}
