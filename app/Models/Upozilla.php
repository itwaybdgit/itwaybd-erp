<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Upozilla extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function customer(): HasMany {
        return $this->hasMany(BandwidthCustomer::class, 'upazila_id', 'id');
    }
}
