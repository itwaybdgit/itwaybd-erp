<?php

namespace Modules\Crm\Entities;

use App\Models\Branch;
use App\Models\Company;
use App\Models\District;
use App\Models\Division;
use App\Models\Upozilla;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyLocation extends Model
{
    use HasFactory;

    protected $casts = [
        'fields' => 'array',
    ];

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
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function division(): BelongsTo {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function district(): BelongsTo {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function upazilla(): BelongsTo {
        return $this->belongsTo(Upozilla::class, 'upazila_id', 'id');
    }
}
