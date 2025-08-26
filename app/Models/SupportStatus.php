<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportStatus extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class, 'status', 'id');
    }

}
