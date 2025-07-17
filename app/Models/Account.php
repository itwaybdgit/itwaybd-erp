<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_name',
        'account_details',
        'head_code',
        'parent_id',
        'is_transaction',
        'amount',
        'company_id',
        'status',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    public function hasAccount()
    {
        return $this->hasMany(AccountTransaction::class, 'account_id', 'id');
    }

    public function parentAccount()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function lable($account, $listtag = '')
    {
        $listtag .= "<li class='breadcrumb-item'><a href='" . route('accounts.subaccount', $account->id) . "'>" . $account->account_name . "</a></li>";
        if ($account->parentAccount) {
            return  $this->lable($account->parentAccount, $listtag);
        }
        return $listtag;
    }

    public function amount_account()
    {
        $accountid = $this->id;
        $accounts = AccountTransaction::where('account_id', $accountid)->selectRaw('SUM(debit) as debit,SUM(credit) as credit')->get();
        $debit = 0;
        $credit = 0;
        $openingbalance = OpeningBalance::where('account_id', $accountid)->pluck('amount')->first();
        foreach ($accounts as $account) {
            $debit += $account->debit;
            $credit += $account->credit;
        }
        return (($debit - $credit) + $openingbalance);
    }

    public function subAccount()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function getTypeOfAccount($id = [], $oldIds = [])
    {
        $ids = Self::whereIn('parent_id', $id)->pluck('id')->toArray();
        if ($ids) {
            $marge = array_merge($ids, $oldIds);
            return Self::getTypeOfAccount($ids, $marge);
        }
        return $oldIds;
    }

    public static  function getaccount($id = null)
    {
        $account_list =  Self::where('status', 'Active');
        if ($id) {
            $account_list = $account_list->whereIn('id', self::getTypeOfAccount([$id]));
        }
        $account_list = $account_list->where('company_id', auth()->user()->company_id);
        return $account_list;
    }
}
