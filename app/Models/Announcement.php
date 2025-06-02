<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
    'tieu_de', 'noi_dung', 'do_quan_trong', 'hien_thi_tu', 'hien_thi_den', 'department_id'
];

public function department()
{
    return $this->belongsTo(Department::class);
}


}
