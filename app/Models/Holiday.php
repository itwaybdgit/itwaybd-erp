<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'status',
        'date',
        'type'
    ];

    // protected $casts = [
    //     'date' => 'date'
    // ];
}
