<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'department_id', 'deadline'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
