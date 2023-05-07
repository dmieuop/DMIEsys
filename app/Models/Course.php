<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Course extends Model
{
    use HasFactory;
    use Userstamps;

    protected $primaryKey = 'course_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
}
