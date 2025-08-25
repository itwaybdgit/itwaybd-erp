<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subtask extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'task_id',
        'title',
        'description',
        'user_id',
        'priority',
        'project_id',
        'status',
        'time_logged',
        'completed_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
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
    const PRIORITY_CRITICAL = 'Critical';

    /**
     * Get all available statuses
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED,
        ];
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
            self::PRIORITY_CRITICAL,
        ];
    }

    /**
     * Get the task that owns the subtask.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user assigned to the subtask.
     */
    public function user()
    {
          return $this->hasOneThrough(User::class, Employee::class, 'id', 'id', 'user_id', 'user_id');
    }

    /**
     * Get the user who created the subtask.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the subtask.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get priority badge class for UI.
     */
    public function getPriorityBadgeClassAttribute()
    {
        switch ($this->priority) {
            case self::PRIORITY_CRITICAL:
                return 'badge-dark';
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



    // This refers to employee table
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function timers()
    {
        return $this->hasMany(SubtaskTimer::class);
    }

    /**
     * Check if subtask is completed.
     */
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if subtask is in progress.
     */
    public function isInProgress()
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    /**
     * Check if subtask is pending.
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Mark subtask as completed.
     */
    public function markAsCompleted($userId = null)
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'completed_at' => now(),
            'updated_by' => $userId,
        ]);

        return $this;
    }

    /**
     * Mark subtask as in progress.
     */
    public function markAsInProgress($userId = null)
    {
        $this->update([
            'status' => self::STATUS_IN_PROGRESS,
            'completed_at' => null,
            'updated_by' => $userId,
        ]);

        return $this;
    }

    /**
     * Mark subtask as pending.
     */
    public function markAsPending($userId = null)
    {
        $this->update([
            'status' => self::STATUS_PENDING,
            'completed_at' => null,
            'updated_by' => $userId,
        ]);

        return $this;
    }

    /**
     * Scope a query to only include subtasks with specific status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include subtasks with specific priority.
     */
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to only include completed subtasks.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include pending subtasks.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include in-progress subtasks.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }

    /**
     * Scope a query to only include subtasks assigned to a specific user.
     */
    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include subtasks for a specific task.
     */
    public function scopeForTask($query, $taskId)
    {
        return $query->where('task_id', $taskId);
    }

    /**
     * Scope a query to search subtasks by title or description.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    public function timerLogs()
    {
        return $this->hasMany(TimerLog::class, 'subtask_id');
    }


    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically update parent task progress when subtask status changes
        static::updated(function ($subtask) {
            if ($subtask->isDirty('status')) {
                $subtask->task->touch(); // This will trigger any observers on the task
            }
        });

        static::created(function ($subtask) {
            $subtask->task->touch();
        });

        static::deleted(function ($subtask) {
            $subtask->task->touch();
        });
    }
}
