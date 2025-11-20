<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'name', 'description'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function subModules()
    {
        return $this->hasMany(Submodules::class);
    }
}
