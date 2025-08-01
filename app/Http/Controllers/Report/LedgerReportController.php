<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountTransaction;
use App\Models\Account;
use App\Models\OpeningBalance;
use Illuminate\Support\Facades\DB;

class LedgerReportController extends Controller
{
    public function index(Request $request)
    {

        $accounts = Account::get();

        if ($request->method() == 'POST') {
            $this->validate($request, [
                'from_date' => 'required',
                'to_date' => 'required',
            ]);
            $findreports = AccountTransaction::selectRaw('debit,credit,account_id,created_at,invoice,remark,type');

            $openingBalance = AccountTransaction::whereDate('created_at', '<=', $request->from_date)->selectRaw('SUM(debit) as debit,SUM(credit) as credit');
            $openingTable = 0;
            if ($request->account_id) {
                $openingBalance = $openingBalance->where('account_id', $request->account_id);
                $openingTable = OpeningBalance::where('account_id', $request->account_id)->latest()->pluck('amount')->first();
            }
            $openingBalance = $openingBalance->first();

            $newOpeningBalance = ($openingBalance->debit - $openingBalance->credit) + $openingTable;
            if ($request->from_date) {
                $findreports = $findreports->whereDate('created_at', '>=', $request->from_date);
            }
            if ($request->to_date) {
                $findreports = $findreports->whereDate('created_at', '<=', $request->to_date);
            }
            if ($request->account_id) {
                $findreports = $findreports->where('account_id', $request->account_id);
            }
            $findreports = $findreports->where("account_id", "!=" ,0)->get();
        }
        return view('report.ledgerindex', get_defined_vars());
    }
}
