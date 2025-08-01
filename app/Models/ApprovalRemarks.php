<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalRemarks extends Model
{
    use HasFactory;

    protected $fillable = [ 'type', 'remarks', 'created_by' ];
}
