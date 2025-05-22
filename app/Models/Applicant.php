<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

   protected $fillable = [
    'full_name',
    'email',
    'phone',
    'birthday',
    'major',
    'university',
    'position',
    'status',
    'cv_path',
    'confirmation',
    'hr_file_status'
];
}
