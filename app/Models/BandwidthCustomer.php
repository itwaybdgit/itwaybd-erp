<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BandwidthCustomer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];


    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'm_p_p_p_profile' => 'integer',
    ];


    public function getImageAttribute($val)
    {
        $img = empty($val) ? asset('img/avatar.png') : asset('storage/' . $val);
        return "<img src='{$img}' style='width:80px;' />";
    }

    public function package()
    {
      return $this->hasMany(BandwidthCustomerPackage::class,"bandwidht_customer_id","id");
    }

    public function legalDocument()
    {
      return $this->hasOne(LegalInfo::class,"bandwidth_customer_id","id");
    }

    public function currentUpgradtion()
    {
     $data = ResellerUpgradation::where('status','pending')->where('customer_id',$this->id)->first();
     return ['created_by' => $data->createby->name ?? ""];

    }

    public function assignby()
    {
      return $this->belongsTo(User::class,"assign_by","id");
    }

    public function transmission()
    {
      return $this->hasOne(Transmission::class,"bandwidth_customer_id","id");
    }

    public function division(): BelongsTo {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function district(): BelongsTo {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function upazilla(): BelongsTo {
        return $this->belongsTo(Upozilla::class, 'upazila_id', 'id');
    }

    public function getewaynoc() {
        return $this->hasOne(GatewayNoc::class, 'bandwidth_customer_id', 'id');
    }

    public function popconnection() {
        return $this->hasOne(PopConnection::class, 'bandwidth_customer_id', 'id');
    }

    public function approveSales(): BelongsTo {
        return $this->belongsTo(User::class, 'sales_approve', 'id');
    }

    public function approveLegal(): BelongsTo {
        return $this->belongsTo(User::class, 'legal_approve', 'id');
    }

    public function approveTranmission(): BelongsTo {
        return $this->belongsTo(User::class, 'transmission_approve', 'id');
    }

    public function approveNoc(): BelongsTo {
        return $this->belongsTo(User::class, 'noc_approve', 'id');
    }

    public function approveNoc2(): BelongsTo {
        return $this->belongsTo(User::class, 'noc2_approve', 'id');
    }

    public function approveBilling(): BelongsTo {
        return $this->belongsTo(User::class, 'billing_approve', 'id');
    }

    public function connectionport() {
        return $this->belongsTo(ConnectedPath::class, 'connection_path_id', 'id');
    }
    public function licensetype() {
        return $this->belongsTo(LicenseType::class, 'license_type', 'id');
    }
    public function kam() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function team() {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

}
