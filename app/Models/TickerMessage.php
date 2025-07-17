<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TickerMessage extends Model
{
    use HasFactory;

    public function assignUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
