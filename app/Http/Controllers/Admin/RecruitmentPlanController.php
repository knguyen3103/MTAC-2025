<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecruitmentPlan;
use Illuminate\Http\Request;
use App\Models\Department;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RecruitmentPlansExport;
class RecruitmentPlanController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $area = $request->input('area');
        $query = RecruitmentPlan::where('year', $year);
        if ($area) {
            $query->where('area', $area);
        }

        $plans = $query->get()->groupBy(['area', 'department_type']);
        return view('admin.recruitments.plans.index', compact('plans'));
    }

    public function create()
        {
            $departments = Department::pluck('ten_phongban', 'id');
            return view('admin.recruitments.plans.create', compact('departments'));
        }

    public function store(Request $request)
        {
            $request->validate([
                'area' => 'required|string',
                'department_type' => 'required|string',
                'year' => 'required|integer',
                'month' => 'required|integer|min:1|max:12',
                'quantity' => 'required|integer|min:0',
                'department_id' => 'required|array',
                'department_id.*' => 'nullable|exists:departments,id',
            ]);

            foreach ($request->department_id as $deptId) {
                RecruitmentPlan::create([
                    'area' => $request->area,
                    'department_type' => $request->department_type,
                    'year' => $request->year,
                    'month' => $request->month,
                    'quantity' => $request->quantity,
                    'department_id' => $deptId,
                ]);
            }

            return redirect()->route('admin.recruitments.plans.index')->with('success', 'Đã thêm kế hoạch cho các phòng ban');
        }


    public function edit($id)
{
    $plan = RecruitmentPlan::findOrFail($id);
    $departments = Department::pluck('ten_phongban', 'id');
    return view('admin.recruitments.plans.edit', compact('plan', 'departments'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'area' => 'required|string',
            'department_type' => 'required|string',
            'month' => 'required|integer|min:1|max:12',
            'quantity' => 'required|integer|min:0',
        ]);

        $plan = RecruitmentPlan::findOrFail($id);
        $plan->update($request->all());

        return redirect()->route('admin.recruitments.plans.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        RecruitmentPlan::destroy($id);
        return redirect()->route('admin.recruitments.plans.index')->with('success', 'Xóa thành công');
    }
    public function department()
        {
            return $this->belongsTo(Department::class);
        }
    public function export()
    {
        return Excel::download(new RecruitmentPlansExport, 'ke_hoach_tuyen_dung.xlsx');
    }

}
