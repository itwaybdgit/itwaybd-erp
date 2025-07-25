<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\Types\Self_;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'phone',
        'is_admin',
        'username',
        'roll_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function detail()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    public function rollaccess()
    {
        return $this->belongsTo(RollPermission::class, 'roll_id', 'id');
    }

    public function msecret()
    {
        return $this->hasOne(M_Secret::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function mac_reseler()
    {
        return $this->hasOne(MacReseller::class, 'user_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(MacReseller::class, 'user_id', 'id');
    }

    public function getmacReseler()
    {
        return auth()->user()->mac_reseler;
    }

    public function salesApprove(): HasMany {
        return $this->hasMany(BandwidthCustomer::class, 'sales_approve_by', 'id');
    }

    public function legalApprove(): HasMany {
        return $this->hasMany(BandwidthCustomer::class, 'legal_approve_by', 'id');
    }
    public function transmissionApprove(): HasMany {
        return $this->hasMany(BandwidthCustomer::class, 'transmission_approve_by', 'id');
    }
    public function nocApprove(): HasMany {
        return $this->hasMany(BandwidthCustomer::class, 'noc_approve_by', 'id');
    }
    public function noc2Approve(): HasMany {
        return $this->hasMany(BandwidthCustomer::class, 'noc2_approve_by', 'id');
    }
    public function billingApprove(): HasMany {
        return $this->hasMany(BandwidthCustomer::class, 'billing_approve_by', 'id');
    }
}
