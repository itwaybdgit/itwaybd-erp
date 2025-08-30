<?php

namespace Modules\Crm\Entities;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'branch_id',
        'division_id',
        'district_id',
        'upazila_id',
        'fields'
    ];

//    protected static function newFactory()
//    {
//        return \Modules\Crm\Database\factories\CompanyLocationFactory::new();
//    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
