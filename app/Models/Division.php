<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['name','details'];

    public function customer(): HasMany {
        return $this->hasMany(BandwidthCustomer::class, 'division_id', 'id');
    }
}
