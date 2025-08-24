<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadGeneration extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

   function meeting() {
    return $this->hasMany(MeetingTime::class,'lead_id','id');
   }
    public function groupCompanies()
    {
        return $this->hasMany(GroupCompany::class);
    }
}
