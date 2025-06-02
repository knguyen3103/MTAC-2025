<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
class RecruitmentPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'area',
        'department_type',
        'department_id',
        'year',
        'month',
        'quantity',
    ];

    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
    }
}

