<?php

namespace App\Http\Controllers\API;

use App\credit;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CreditController extends Controller
{
    public function index()
    {
        return credit::with('department', 'income_source')->latest()->paginate(10);

    }

    public function SearchCreditReport(Request $request)
    {
        $action = 'hide';
        $credit = credit::with('department', 'income_source');
        if ($request->date != null) {
            $date = DateTime::createFromFormat('d/m/Y', $request->date);
            $credit = $credit->where('date', $date->format('Y-m-d'));
            $action = 'show';
        }

        if ($request->department_id != null) {
            $credit = $credit->where('department_id', $request->department_id);
            $action = 'show';
        }

        if ($request->month != null) {
            $month = $request->month;
            $month = explode("-", $month);
            $credit = $credit->whereYear('date', '=', $month[1])
                ->whereMonth('date', '=', $month[0]);
            $action = 'show';
        }

        $credit = $credit->latest()->get();

        $output = array(
            'sum' => $credit->sum('amount'),
            'data' => $credit,
            'action' => $action,
        );
        return json_encode($output);

    }

    public function TotalCredit()
    {
        return credit::all()->sum('amount');

    }

    public function CreditMonth()
    {
        return credit::select(DB::raw('MONTH(date) as month, YEAR(date) as year'))
            ->groupBy(DB::raw('YEAR(date) DESC, MONTH(date) DESC'))->get();

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => "Required",
            'voucher_no' => 'Required',
            'department_id' => 'Required',
            'income_source_id' => 'Required',
            'payment_mode' => 'Required',
            'bank_deposit' => 'max:191',
            'previous_bank_balance' => 'max:191',
            'amount' => 'Required|integer',
            'remarks' => 'max:191',
        ]);

        $date = DateTime::createFromFormat('d/m/Y', $request->date);

        $insert = new credit();
        $insert->date = $date->format('Y-m-d');
        $insert->voucher_no = $request->voucher_no;
        $insert->department_id = $request->department_id;
        $insert->income_source_id = $request->income_source_id;
        $insert->payment_mode = $request->payment_mode;
        $insert->bank_deposit = $request->bank_deposit;
        $insert->previous_bank_balance = $request->previous_bank_balance;
        $insert->amount = $request->amount;
        $insert->remarks = $request->remarks;
        $insert->save();
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'date' => "Required",
            'voucher_no' => 'Required',
            'department_id' => 'Required',
            'income_source_id' => 'Required',
            'payment_mode' => 'Required',
            'bank_deposit' => 'max:191',
            'previous_bank_balance' => 'max:191',
            'amount' => 'Required|integer',
            'remarks' => 'max:191',
        ]);
        $insert = credit::findOrFail($id);
        $insert->date = $request->date;
        $insert->voucher_no = $request->voucher_no;
        $insert->department_id = $request->department_id;
        $insert->income_source_id = $request->income_source_id;
        $insert->payment_mode = $request->payment_mode;
        $insert->bank_deposit = $request->bank_deposit;
        $insert->previous_bank_balance = $request->previous_bank_balance;
        $insert->amount = $request->amount;
        $insert->remarks = $request->remarks;
        $insert->save();
    }

    public function destroy($id)
    {
        $department = credit::findOrFail($id);
        $department->delete();
        return ['message' => 'User deleted'];
    }
}
