<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingTime extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function lead() {
      return $this->belongsTo(LeadGeneration::class);
    }
}
