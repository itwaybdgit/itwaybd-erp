<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskRequest extends Model
{
     protected $fillable = [
        'title',
        'description',
        'requester_id',
        'requested_user_id',
        'status', // 'pending', 'accepted', 'rejected'
        'priority',
        'due_date'
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function requestedUser()
    {
        return $this->belongsTo(User::class, 'requested_user_id');
    }

    public function task()
    {
        return $this->hasOne(Task::class);
    }
}
