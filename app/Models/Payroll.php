<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

      public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
  function account()
    {
      return $this->morphOne(Accounts::class, "accountable");
    }
     // Accessor to get formatted month year
    public function getMonthYearAttribute()
    {
        return $this->month . ' ' . $this->year;
    }

    // Scope to filter by employee
    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    // Scope to filter by month and year
    public function scopeForPeriod($query, $month, $year)
    {
        return $query->where('month', $month)->where('year', $year);
    }

}
