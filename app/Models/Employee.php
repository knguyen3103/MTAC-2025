<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'ma_nhanvien', 'ma_cham_cong', 'ho_ten', 'gioi_tinh', 'ngay_sinh',
        'so_dien_thoai', 'email', 'vi_tri', 'chuc_vu', 'department_id',
        'trang_thai',

        'ngay_vao_thu_viec', 'ngay_ket_thuc_thu_viec', 'ket_qua_thu_viec',
        'ngay_vao_hoc_viec', 'ngay_ket_thuc_hoc_viec', 'ket_qua_hoc_viec',
        'ngay_vao_chinh_thuc',

        'ngay_thuc_tap', 'ngay_ket_thuc_thuc_tap', 'de_tai_thuc_tap', 'danh_gia_thuc_tap',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
