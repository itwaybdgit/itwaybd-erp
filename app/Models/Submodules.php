<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submodules extends Model
{
    use HasFactory;
    protected $fillable = ['modules_id', 'name', 'description'];

    public function module()
    {
        return $this->belongsTo(Modules::class);
    }
}
