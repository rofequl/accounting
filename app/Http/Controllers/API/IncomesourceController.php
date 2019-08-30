<?php

namespace App\Http\Controllers\API;

use App\income_source;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IncomesourceController extends Controller
{
    public function index()
    {
        return income_source::with('department')->latest()->paginate(10);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'income_source' => "Required|max:191|unique_with:income_sources, department_id",
            'department_id' => 'Required'
        ]);

        $insert = new income_source();
        $insert->income_source = $request->income_source;
        $insert->department_id = $request->department_id;
        $insert->remarks = $request->remarks;
        $insert->save();
    }

    public function show($id)
    {
        return income_source::where('department_id',$id)->get();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'income_source' => "Required|max:191|unique_with:income_sources, department_id,$id",
            'department_id' => 'Required'
        ]);

        $insert = income_source::findOrFail($id);
        $insert->income_source = $request->income_source;
        $insert->department_id = $request->department_id;
        $insert->remarks = $request->remarks;
        $insert->save();
    }

    public function destroy($id)
    {
        $department = income_source::findOrFail($id);
        $department->delete();
        return ['message'=>'User deleted'];
    }
}
