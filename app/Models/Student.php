<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Student extends Model
{
    use HasFactory;
    use Userstamps;

    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function getAdvisor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(App\Models\User::class, 'id', 'student_advisor');
    }

    public function getAdvisoryComments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(App\Models\AdvisoryComment::class, 'student_id', 'student_id');
    }

    public function scopeUndergraduate(object $query): object
    {
        return $query->where('graduated', '0');
    }
}
