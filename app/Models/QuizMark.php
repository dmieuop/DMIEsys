<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class QuizMark extends Model
{
    use HasFactory;
    use Userstamps;

    protected $guarded = [];
}
