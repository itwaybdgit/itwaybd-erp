<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start_date_time',
        'end_date_time',
        'status',
        'priority',
        'project_id',
        'image',
        'team_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_date_time' => 'datetime',
        'end_date_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    // Status constants
    const STATUS_PENDING = 'Pending';
    const STATUS_IN_PROGRESS = 'In Progress';
    const STATUS_COMPLETED = 'Completed';

    // Priority constants
    const PRIORITY_LOW = 'Low';
    const PRIORITY_MEDIUM = 'Medium';
    const PRIORITY_HIGH = 'High';

    /**
     * Get all available statuses
     */
    public static function getStatuses()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get all available priorities
     */
    public static function getPriorities()
    {
        return [
            self::PRIORITY_LOW,
            self::PRIORITY_MEDIUM,
            self::PRIORITY_HIGH,
        ];
    }

    /**
     * Get the project that owns the task.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who created the task.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the task.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the subtasks for the task.
     */
    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function areAllSubtasksComplete()
    {
        return $this->subtasks()->where('status', '!=', 'Completed')->count() === 0;
    }


    public function team()
    {
        return $this->belongsTo(Team::class)->withDefault();
    }

    /**
     * Get the task messages for the task.
     */
    public function taskMessages()
    {
        return $this->hasMany(TaskMessage::class);
    }

    /**
     * Get the users assigned to this task through subtasks.
     */
    public function assignedUsers()
    {
        return $this->hasManyThrough(Employee::class, Subtask::class, 'task_id', 'id', 'id', 'user_id');
    }

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    /**
     * Check if task is overdue.
     */
    public function isOverdue()
    {
        return $this->end_date_time < now() && $this->status !== self::STATUS_COMPLETED;
    }

    /**
     * Get task progress percentage based on completed subtasks.
     */
    public function getProgressAttribute()
    {
        $totalSubtasks = $this->subtasks()->count();

        if ($totalSubtasks === 0) {
            return $this->status === self::STATUS_COMPLETED ? 100 : 0;
        }

        $completedSubtasks = $this->subtasks()
            ->where('status', Subtask::STATUS_COMPLETED)
            ->count();

        return round(($completedSubtasks / $totalSubtasks) * 100, 2);
    }

    /**
     * Get priority badge class for UI.
     */
    public function getPriorityBadgeClassAttribute()
    {
        switch ($this->priority) {
            case self::PRIORITY_HIGH:
                return 'badge-danger';
            case self::PRIORITY_MEDIUM:
                return 'badge-warning';
            case self::PRIORITY_LOW:
                return 'badge-info';
            default:
                return 'badge-secondary';
        }
    }

    /**
     * Get status badge class for UI.
     */
    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case self::STATUS_COMPLETED:
                return 'badge-success';
            case self::STATUS_IN_PROGRESS:
                return 'badge-primary';
            case self::STATUS_PENDING:
                return 'badge-warning';
            default:
                return 'badge-secondary';
        }
    }

    /**
     * Get days remaining until deadline.
     */
    public function getDaysRemainingAttribute()
    {
        if ($this->status === self::STATUS_COMPLETED) {
            return 0;
        }

        $now = now();
        $endDate = $this->end_date_time;

        if ($endDate < $now) {
            return -$now->diffInDays($endDate); // Negative for overdue
        }

        return $now->diffInDays($endDate);
    }

    /**
     * Scope a query to only include tasks with specific status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include tasks with specific priority.
     */
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to only include overdue tasks.
     */
    public function scopeOverdue($query)
    {
        return $query->where('end_date_time', '<', now())
            ->where('status', '!=', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include tasks due today.
     */
    public function scopeDueToday($query)
    {
        return $query->whereDate('end_date_time', today())
            ->where('status', '!=', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include tasks for a specific project.
     */
    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    /**
     * Scope a query to only include tasks assigned to a specific user.
     */
    public function scopeAssignedToUser($query, $userId)
    {
        return $query->whereHas('subtasks', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    /**
     * Scope a query to search tasks by title or description.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // When deleting a task, also delete its image
        static::deleting(function ($task) {
            if ($task->image && Storage::disk('public')->exists($task->image)) {
                Storage::disk('public')->delete($task->image);
            }
        });
    }
}
