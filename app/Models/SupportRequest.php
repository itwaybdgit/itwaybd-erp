<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    protected $fillable = [
        'task_id',
        'subtask_id',
        'subtask_title',
        'requester_id',
        'supporter_id',
        'support_type',
        'message',
        'status'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function subtask()
    {
        return $this->belongsTo(Subtask::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function supporter()
    {
        return $this->belongsTo(User::class, 'supporter_id');
    }
}
