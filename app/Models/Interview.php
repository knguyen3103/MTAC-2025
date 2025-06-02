<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'full_name',
        'email',
        'position',
        'interview_time',
        'note',
        'status',
        'confirmation_status',
    ];

    /**
     * Quan hệ 1-n: Một thư mời có nhiều xác nhận
     */
    public function confirmations(): HasMany
    {
        return $this->hasMany(\App\Models\InterviewConfirmation::class);
    }
}
    