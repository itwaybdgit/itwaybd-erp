<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResellerNIRequest extends Model
{
    use HasFactory;
//    protected $casts = [
//        'package' => 'array',
//    ];

    protected $table = 'reseller_nirequests'; // Correct table name specified
    protected $guarded = ['id'];

    public function customer() {
        return $this->belongsTo(BandwidthCustomer::class);
    }

    public function kam() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
