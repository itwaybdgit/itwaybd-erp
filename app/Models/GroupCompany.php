<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupCompany extends Model
{
    use HasFactory;

    protected $fillable = ['company_name', 'business_type_id'];

    public function lead()
    {
        return $this->belongsTo(LeadGeneration::class);
    }
}
