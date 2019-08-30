<?php

namespace App\Http\Controllers\API;

use App\credit;
use App\debit;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use function Symfony\Component\VarDumper\Dumper\esc;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ReportController extends Controller
{

    public function index()
    {
        $debit = debit::select('date', DB::raw('SUM(amount) as total_debit'))->groupBy('date')->get()->toArray();
        $credit = credit::select('date', DB::raw('SUM(amount) as total_credit, SUM(previous_bank_balance) as bank_balance'))->groupBy('date')->get()->toArray();
        $data = array_merge($debit, $credit);
        $collectionOld = new Collection($data);
        $collectionOld = $collectionOld->sortByDesc('date');
        $collection = new Collection();

        foreach ($collectionOld as $collectionOlds) {
            $filtered = $collection->where('date', $collectionOlds['date']);
            if ($filtered->isNotEmpty()) {
                $keys = $filtered->keys()->first();
                if (isset($collectionOlds['total_credit'])) {
                    $collection[$keys] += ['total_credit' => $collectionOlds['total_credit'], 'bank_balance' => (int)$collectionOlds['bank_balance']];
                }
                if (isset($collectionOlds['total_debit'])) {
                    $collection[$keys] += ['total_debit' => $collectionOlds['total_debit']];
                }
            } else {
                if (isset($collectionOlds['total_credit'])) {
                    $collection->push(['date' => $collectionOlds['date'], 'total_credit' => $collectionOlds['total_credit'], 'bank_balance' => (int)$collectionOlds['bank_balance']]);
                }
                if (isset($collectionOlds['total_debit'])) {
                    $collection->push(['date' => $collectionOlds['date'], 'total_debit' => $collectionOlds['total_debit']]);
                }
            }
        }

        foreach ($collection as $collections) {
            $filtered = $collection->where('date', $collections['date']);
            $keys = $filtered->keys()->first();
            if (!isset($collections['total_credit'])) {
                $collection[$keys] += ['total_credit' => 0, 'bank_balance' => 0];
            }
            if (!isset($collections['total_debit'])) {
                $collection[$keys] += ['total_debit' => 0];
            }
            $collection[$keys] += ['profit_loss' => $collection[$keys]['total_credit'] - $collection[$keys]['total_debit']];
            $collection[$keys] += ['total_balance' => $collection[$keys]['profit_loss'] + $collection[$keys]['bank_balance']];
        }

        $chunk = $collection->paginate(10);
        return $chunk;
    }

    public function TotalBalanceSheet(Request $request){
        $debit = debit::select('date', DB::raw('SUM(amount) as total_debit'))->groupBy('date')->get()->toArray();
        $credit = credit::select('date', DB::raw('SUM(amount) as total_credit, SUM(previous_bank_balance) as bank_balance'))->groupBy('date')->get()->toArray();
        $data = array_merge($debit, $credit);
        $collectionOld = new Collection($data);
        $collectionOld = $collectionOld->sortByDesc('date');
        $collection = new Collection();

        foreach ($collectionOld as $collectionOlds) {
            $filtered = $collection->where('date', $collectionOlds['date']);
            if ($filtered->isNotEmpty()) {
                $keys = $filtered->keys()->first();
                if (isset($collectionOlds['total_credit'])) {
                    $collection[$keys] += ['total_credit' => $collectionOlds['total_credit'], 'bank_balance' => (int)$collectionOlds['bank_balance']];
                }
                if (isset($collectionOlds['total_debit'])) {
                    $collection[$keys] += ['total_debit' => $collectionOlds['total_debit']];
                }
            } else {
                if (isset($collectionOlds['total_credit'])) {
                    $collection->push(['date' => $collectionOlds['date'], 'total_credit' => $collectionOlds['total_credit'], 'bank_balance' => (int)$collectionOlds['bank_balance']]);
                }
                if (isset($collectionOlds['total_debit'])) {
                    $collection->push(['date' => $collectionOlds['date'], 'total_debit' => $collectionOlds['total_debit']]);
                }
            }
        }

        foreach ($collection as $collections) {
            $filtered = $collection->where('date', $collections['date']);
            $keys = $filtered->keys()->first();
            if (!isset($collections['total_credit'])) {
                $collection[$keys] += ['total_credit' => 0, 'bank_balance' => 0];
            }
            if (!isset($collections['total_debit'])) {
                $collection[$keys] += ['total_debit' => 0];
            }
            $collection[$keys] += ['profit_loss' => $collection[$keys]['total_credit'] - $collection[$keys]['total_debit']];
            $collection[$keys] += ['total_balance' => $collection[$keys]['profit_loss'] + $collection[$keys]['bank_balance']];
        }

        $chunk = $collection->sum('total_balance');
        return $chunk;
    }

    public function search(Request $request)
    {
        $action = 'hide';
        $debit = debit::select('date', DB::raw('SUM(amount) as total_debit'));
        $credit = credit::select('date', DB::raw('SUM(amount) as total_credit, SUM(previous_bank_balance) as bank_balance'));
        if ($request->date != null) {
            $date = DateTime::createFromFormat('d/m/Y', $request->date);
            $debit = $debit->where('date', $date->format('Y-m-d'));
            $credit = $credit->where('date', $date->format('Y-m-d'));
            $action = 'show';
        }
        if ($request->month != null) {
            $month = $request->month;
            $month = explode("-", $month);
            $credit = $credit->whereYear('date', '=', $month[1])->whereMonth('date', '=', $month[0]);
            $debit = $debit->whereYear('date', '=', $month[1])->whereMonth('date', '=', $month[0]);
            $action = 'show';
        }
        if ($request->department_id != null) {
            $credit = $credit->where('department_id', $request->department_id);
            $debit = $debit->where('department_id', $request->department_id);
            $action = 'show';
        }
        $debit = $debit->groupBy('date')->get()->toArray();
        $credit = $credit->groupBy('date')->get()->toArray();
        $data = array_merge($debit, $credit);
        $collectionOld = new Collection($data);
        $collectionOld = $collectionOld->sortByDesc('date');
        $collection = new Collection();

        foreach ($collectionOld as $collectionOlds) {
            $filtered = $collection->where('date', $collectionOlds['date']);
            if ($filtered->isNotEmpty()) {
                $keys = $filtered->keys()->first();
                if (isset($collectionOlds['total_credit'])) {
                    $collection[$keys] += ['total_credit' => $collectionOlds['total_credit'], 'bank_balance' => (int)$collectionOlds['bank_balance']];
                }
                if (isset($collectionOlds['total_debit'])) {
                    $collection[$keys] += ['total_debit' => $collectionOlds['total_debit']];
                }
            } else {
                if (isset($collectionOlds['total_credit'])) {
                    $collection->push(['date' => $collectionOlds['date'], 'total_credit' => $collectionOlds['total_credit'], 'bank_balance' => (int)$collectionOlds['bank_balance']]);
                }
                if (isset($collectionOlds['total_debit'])) {
                    $collection->push(['date' => $collectionOlds['date'], 'total_debit' => $collectionOlds['total_debit']]);
                }
            }
        }

        foreach ($collection as $collections) {
            $filtered = $collection->where('date', $collections['date']);
            $keys = $filtered->keys()->first();
            if (!isset($collections['total_credit'])) {
                $collection[$keys] += ['total_credit' => 0, 'bank_balance' => 0];
            }
            if (!isset($collections['total_debit'])) {
                $collection[$keys] += ['total_debit' => 0];
            }
            $collection[$keys] += ['profit_loss' => $collection[$keys]['total_credit'] - $collection[$keys]['total_debit']];
            $collection[$keys] += ['total_balance' => $collection[$keys]['profit_loss'] + $collection[$keys]['bank_balance']];
        }

        $output = array(
            'sum' => $collection->sum('total_balance'),
            'data' => $collection,
            'action' => $action,
        );
        return json_encode($output);
    }


    public function month()
    {
        $debit = debit::select(DB::raw('MONTH(date) as month, YEAR(date) as year'))
            ->groupBy(DB::raw('YEAR(date) DESC, MONTH(date) DESC'))->get()->toArray();

        $credit = credit::select(DB::raw('MONTH(date) as month, YEAR(date) as year'))
            ->groupBy(DB::raw('YEAR(date) DESC, MONTH(date) DESC'))->get()->toArray();

        $data = array_unique(array_merge($debit, $credit), SORT_REGULAR);
        return $data;
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
