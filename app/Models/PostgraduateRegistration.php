<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostgraduateRegistration extends Model
{
    use HasFactory;

    /** @var string */
    protected $primaryKey = 'nic';
    /** @var bool */
    public $incrementing = false;
    /** @var string */
    protected $keyType = 'string';
    /** @var string[] */
    protected $guarded = [];

    /** @var string[] */
    protected $fillable = [
        'nic',
        'applied_degree',
        'degree_cat',
        'fname',
        'lname',
        'fullname',
        'email',
        'phone',
        'birthday',
        'address',
        'gender',
        'employment',
        'noofuniversities',
        'noofcompanies',
        'noofmemberships',
        'year',
        'file_path',
        'r1_is_submit',
        'r2_is_submit',
        'ip',
        'random_phase',
    ];

    public function getCompany(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(App\Models\PGRCompany::class, 'nic', 'nic');
    }

    public function getUniversity(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(App\Models\PGRUniversity::class, 'nic', 'nic');
    }

    public function getMembership(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(App\Models\PGRMembership::class, 'nic', 'nic');
    }

    public function getReferee(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(App\Models\PGRReferee::class, 'nic', 'nic');
    }
}
