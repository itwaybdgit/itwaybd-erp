<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimerLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'task_id',
        'subtask_id',
        'title',
        'started_at',
        'ended_at',
        'duration_seconds',
        'status',
        'notes'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function subtask()
    {
        return $this->belongsTo(Subtask::class);
    }

    // Get current running time in seconds
    public function getCurrentDuration()
    {
        if ($this->status === 'active') {
            return Carbon::now()->diffInSeconds($this->started_at);
        }
        return $this->duration_seconds;
    }

    // Get formatted time
    public function getFormattedDuration()
    {
        $seconds = $this->getCurrentDuration();
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }

    // Scope for active timers
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope for specific employee
    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    // Static method to get active timer for employee
    public static function getActiveTimerForEmployee($employeeId)
    {
        return self::where('employee_id', $employeeId)
                   ->where('status', 'active')
                   ->first();
    }

    // Stop the timer and calculate duration
    public function stop()
    {
        if ($this->status === 'active') {
            $this->ended_at = Carbon::now();
            $this->duration_seconds = $this->ended_at->diffInSeconds($this->started_at);
            $this->status = 'completed';
            $this->save();

            return $this->duration_seconds;
        }

        return 0;
    }

    // Pause the timer
    public function pause()
    {
        if ($this->status === 'active') {
            $this->ended_at = Carbon::now();
            $this->duration_seconds = $this->ended_at->diffInSeconds($this->started_at);
            $this->status = 'paused';
            $this->save();

            return $this->duration_seconds;
        }

        return 0;
    }
}
