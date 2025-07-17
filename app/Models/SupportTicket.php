<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function customer()
    {
        return $this->belongsTo(BandwidthCustomer::class, 'client_id', 'id');
    }

    public function problem()
    {
        return $this->belongsTo(SupportCategory::class, 'problem_category', 'id');
    }

    public function assignUser()
    {
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }

    public function supportstatus()
    {
        return $this->belongsTo(SupportStatus::class, 'status', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return  Carbon::parse($value)->diffForHumans();
    }

    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function solveby()
    {
        return $this->belongsTo(User::class, 'solve_by', 'id');
    }
}
