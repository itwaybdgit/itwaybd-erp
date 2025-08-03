<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'id_card',
        'email',
        'status',
        'password',
        'user_id',
        'dob',
        'gender',
        'personal_phone',
        'office_phone',
        'marital_status',
        'nid',
        'last_in_time',
        'reference',
        'experience',
        'Active_address',
        'permanent_address',
        'department_id',
        'designation_id',
        'achieved_degree',
        'institution',
        'passing_year',
        'type',
        'salary',
        'join_date',
        'image',
        'emp_signature',
        'team',
        'updated_by',
        'created_by',
        'deleted_by',
        'over_time_is',
        'blood_group',
        'is_login',
        'supervisor',
        'official_email',
        'professional_experiences',
        'tax_deduction',
        'tin',
        'bank_account_information',
        'received_documents_checkbox',
    ];

    public function employelist()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function teams()
    {
        return $this->belongsTo(Team::class, "team", 'id');
    }
    public function departments()
    {
        return $this->belongsTo(Department::class, "department_id", 'id');
    }
    public function designations()
    {
        return $this->belongsTo(Designation::class, "designation_id", 'id');
    }
}
