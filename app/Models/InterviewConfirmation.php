<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewConfirmation extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',
        'status',
        'note',
    ];

    public function interview(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Interview::class);
    }
}
