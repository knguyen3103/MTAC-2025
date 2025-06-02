<?php

namespace App\Exports;

use App\Models\RecruitmentPlan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecruitmentPlansExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return RecruitmentPlan::with('department')->get()->map(function ($plan) {
            return [
                'Khu vực' => $plan->area,
                'Loại' => $plan->department_type,
                'Phòng ban' => $plan->department->ten_phongban ?? '—',
                'Tháng' => $plan->month,
                'Năm' => $plan->year,
                'Số lượng' => $plan->quantity,
            ];
        });
    }

    public function headings(): array
    {
        return ['Khu vực', 'Loại', 'Phòng ban', 'Tháng', 'Năm', 'Số lượng'];
    }
}
