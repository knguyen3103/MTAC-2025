<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Applicant::query();

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

    public function approved(Request $request)
    {
        $status = $request->query('status');

        $query = Applicant::query();

        if ($status) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['Đã phỏng vấn', 'Trúng tuyển', 'Loại']);
        }

        $applicants = $query->get();
        return view('admin.applicants.approved', compact('applicants', 'status'));
    }

    public function accepted()
    {
        $applicants = Applicant::where('status', 'Trúng tuyển')->get();
        return view('admin.applicants.accepted', compact('applicants'));
    }

    public function confirm(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->confirmation = $request->input('confirmation');
        $applicant->save();

        return redirect()->route('admin.applicants.accepted')->with('success', 'Đã cập nhật xác nhận hồ sơ.');
    }

    public function updateHRFileStatus(Request $request, $id)
    {
        $request->validate([
            'hr_file_status' => 'nullable|string|max:255'
        ]);

        $applicant = Applicant::findOrFail($id);
        $applicant->hr_file_status = $request->input('hr_file_status');
        $applicant->save();

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái hồ sơ nhân sự.');
    }

            public function hrFileStatus()
        {
            $applicants = Applicant::whereNotNull('hr_file_status')->get();
            return view('admin.applicants.hr', compact('applicants'));
        }

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
    public function statistics()
{
    $totalApplicants = Applicant::count();
    $interviewed = Applicant::where('status', 'Đã phỏng vấn')->count();
    $accepted = Applicant::where('status', 'Trúng tuyển')->count();
    $rejected = Applicant::where('status', 'Loại')->count();

    // ✅ Thêm dữ liệu xác nhận hồ sơ
    $confirmed = Applicant::where('confirmation', 'Đã đồng ý')->count();
    $unconfirmed = Applicant::where('confirmation', 'Không đồng ý')->count();
    $other = Applicant::whereNotIn('confirmation', ['Đã đồng ý', 'Không đồng ý'])
                      ->whereNotNull('confirmation')
                      ->count();

    return view('admin.applicants.statistics', compact(
        'totalApplicants',
        'interviewed',
        'accepted',
        'rejected',
        'confirmed',
        'unconfirmed',
        'other'
    ));
}





}
