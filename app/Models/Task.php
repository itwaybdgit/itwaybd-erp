<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Taskmassage;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date_time',
        'end_date_time',
        'status',
        'priority',
        'project_id',
        'assigned_to',
        'created_by',
        'image'
    ];

    protected $casts = [
        'start_date_time' => 'datetime',
        'end_date_time' => 'datetime',
    ];

    // Relationships
    public function getProject()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function messages()
    {
        return $this->hasMany(TaskMessage::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Pending' => 'warning',
            'In Progress' => 'info',
            'Completed' => 'success'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getPriorityBadgeAttribute()
    {
        $badges = [
            'Low' => 'success',
            'Medium' => 'warning',
            'High' => 'danger',
            'Critical' => 'dark'
        ];

        return $badges[$this->priority] ?? 'secondary';
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/task_images/' . $this->image) : null;
    }
}
