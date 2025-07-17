<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResellerUpgradation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function customer() {
      return $this->belongsto(BandwidthCustomer::class,'customer_id','id');
    }

    function createby() {
      return $this->belongsto(User::class,'created_by','id');
    }
}
