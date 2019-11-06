<?php

namespace App\Http\Controllers\API;

use App\debit;
use App\payment;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DebitController extends Controller
{

    public function index()
    {
        return debit::with('department','expenditure','payment')->latest()->paginate(10);
    }

    public function DebitMonth()
    {
        return debit::select(DB::raw('MONTH(date) as month, YEAR(date) as year'))
            ->groupBy(DB::raw('YEAR(date) DESC, MONTH(date) DESC'))->get();

    }
    public function TotalDebit()
    {
        return debit::all()->sum('amount');

    }
    public function SearchDebitReport(Request $request)
    {
        $action = 'hide';
        $credit = debit::with('department', 'expenditure');
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => "Required",
            'voucher_no' => 'Required|unique:debits,voucher_no,',
            'department_id' => 'Required',
            'expenditure_id' => 'Required',
            'amount' => 'Required|integer|digits_between:1,10',
            'payment_id' => 'Required',
            'previous_amount' => 'Required|integer',
            'total_amount' => 'Required|integer',
            'remarks' => 'max:191',
        ]);

        $date = DateTime::createFromFormat('d/m/Y', $request->date);

        $insert = new debit();
        $insert->date = $date->format('Y-m-d');
        $insert->voucher_no = $request->voucher_no;
        $insert->department_id = $request->department_id;
        $insert->expenditure_id = $request->expenditure_id;
        $insert->amount = $request->amount;
        $insert->payment_id = $request->payment_id;
        $insert->previous_amount = $request->previous_amount;
        $insert->total_amount = $request->total_amount;
        $insert->remarks = $request->remarks;
        if($request->image){
            $name = time().'.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
            \Image::make($request->image)->save(public_path('image/credit/').$name);
            $insert->image = $name;
        }
        $insert->save();

        $insert2 = payment::findOrFail($request->payment_id);
        $insert2->amount = $request->total_amount;
        $insert2->save();
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
            'expenditure_id' => 'Required',
            'payment_mode' => 'Required',
            'amount' => 'Required|integer',
            'remarks' => 'max:191',
        ]);
        $insert = debit::findOrFail($id);
        $insert->date = $request->date;
        $insert->voucher_no = $request->voucher_no;
        $insert->department_id = $request->department_id;
        $insert->expenditure_id = $request->expenditure_id;
        $insert->payment_mode = $request->payment_mode;
        $insert->amount = $request->amount;
        $insert->remarks = $request->remarks;
        $insert->save();
    }

    public function destroy($id)
    {
        $department = debit::findOrFail($id);

        $insert2 = payment::findOrFail($department->payment_id);
        $amount = $insert2->amount + $department->amount;
        $insert2->amount = $amount;
        $insert2->save();

        $department->delete();
        return ['message'=>'User deleted'];
    }
}
