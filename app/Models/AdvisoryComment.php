<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvisoryComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'comment',
        'commented_by',
        'need_attention',
        'is_handled',
        'handled_by',
    ];

    protected $hidden = [
        'comment'
    ];

    protected $casts = [
        'comment' => 'encrypted',
    ];

    public function hasStudent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(App\Models\Student::class, 'student_id', 'student_id');
    }

    public function hasAdvisor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(App\Models\User::class, 'commented_by', 'id');
    }
}
