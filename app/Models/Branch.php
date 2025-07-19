<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    function createdBy() {
        return $this->belongsTo(User::class,"created_by","id");
    }

    function paymentGeteWay() {
      return $this->morphMany(PaymentGatWay::class,"table");
    }

    function user() {
      return $this->belongsTo(User::class);
    }

    function scopeCondition($query)
    {
        if (get_setting('show_branch') == "yes") {
            if (auth()->user()->getBranch) {
                $query = $query->where( "id", auth()->user()->getBranch->id);
            }

            if (isset(auth()->user()->employee->getbranch)) {
                $query = $query->where( "id", auth()->user()->employee->getBranch->id);
            }
        }

        return $query;
    }

}
