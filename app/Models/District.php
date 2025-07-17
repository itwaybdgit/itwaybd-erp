<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function customer(): HasMany {
        return $this->hasMany(BandwidthCustomer::class, 'district_id', 'id');
    }

    function division() {
      return $this->belongsTo(Division::class);
    }
}
