<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function lead()
    {
        return $this->belongsTo(LeadGeneration::class,  'lead_generation_id');
    }
    public function products()
    {
        return $this->hasMany(OpportunityProduct::class, 'opportunity_id');
    }
}
