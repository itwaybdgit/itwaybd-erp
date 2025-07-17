<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResellerDiscontinue extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    function customer() {
        return $this->belongsTo(BandwidthCustomer::class);
      }
      function kam() {
        return $this->belongsTo(User::class,'created_by','id');
      }
}
