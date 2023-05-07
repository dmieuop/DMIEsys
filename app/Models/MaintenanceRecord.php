<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class MaintenanceRecord extends Model
{
    use HasFactory, Userstamps;

    protected $guarded = [];

    public function scopeOpen(Builder $query): void
    {
        $query->where('comments', null);
    }

    public function scopeTodayOpen(Builder $query): void
    {
        $query->where('due_date', today()->toDateString())->where('comments', null);;
    }

    public function hasMachine(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Machine::class, 'machine_id', 'id');
    }

    public function hasTask(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MaintenanceSchedule::class, 'task_id', 'id');
    }

    public function getUser(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
