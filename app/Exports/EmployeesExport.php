<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Employee::select('ma_nhanvien', 'ho_ten', 'email', 'vi_tri', 'trang_thai')->get();
    }

    public function headings(): array
    {
        return [
            'Mã nhân viên',
            'Họ và tên',
            'Email',
            'Vị trí',
            'Trạng thái',
        ];
    }
}
