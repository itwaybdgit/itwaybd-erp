<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revert extends Model
{
    use HasFactory;
    protected $guarded = [
       'id',
    ];

   function revertperson() {
     return $this->belongsTo(User::class,'revert_by','id');
   }

   function bandwidthcustomer() {
     return $this->belongsTo(BandwidthCustomer::class,'table_id','id');
   }
}
