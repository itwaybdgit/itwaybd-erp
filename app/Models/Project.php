<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Project extends Model
{
    use HasFactory;

 protected $fillable = [
        'name',
        'starting_date',
        'ending_date',
        'description',
        'hypercare_months',
        'client_id',
        'status',
        'priority',
        'estimated_hours',
        'progress',
        'budget',
        'tags',
        'notes',
    ];

    public function getTasks()
    {
        return $this->hasMany(Task::class);
    }
}
