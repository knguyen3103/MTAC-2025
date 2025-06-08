<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['ten_phongban', 'ma_phongban'];

    public function employees()
    {
        return $this->hasMany(\App\Models\Employee::class, 'department_id');
    }
    public function recruitments()
        {
            return $this->hasMany(Recruitment::class, 'department_id');
        }

}

