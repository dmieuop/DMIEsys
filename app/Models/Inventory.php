<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Wildside\Userstamps\Userstamps;

class Inventory extends Model implements Auditable
{
    use HasFactory, SoftDeletes, Userstamps;
    use \OwenIt\Auditing\Auditable;

    // protected $primaryKey = 'item_code';
    // public $incrementing = false;
    // protected $keyType = 'string';
    // protected $guarded = [];

    protected $fillable = [
        'item_code',
        'item_name',
        'received_date',
        'indent_no',
        'supplier_name',
        'model',
        'serial_number',
        'properties',
        'book_no',
        'folio_no',
        'value',
        'budget_allocation',
        'location',
        'remark',
        'image_path'
    ];
}
