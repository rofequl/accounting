<?php

namespace App\Http\Controllers\API;

use App\department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function index()
    {
        return department::with('income_source')->latest()->paginate(10);
    }

    public function DepartmentAll()
    {
        return department::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'Required|max:191|unique:departments,name,',
        ]);

        $insert = new department();
        $insert->name = $request->name;
        $insert->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'Required|max:191|unique:departments,name,'.$id,
        ]);

        $insert = department::findOrFail($id);
        $insert->name = $request->name;
        $insert->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = department::findOrFail($id);
        if ($department->income_source->count() > 0 || $department->credit->count() > 0 || $department->debit->count() > 0){
            return ['error'=>'This department all ready used, you can\'t delete'];
        }
        $department->delete();
        return ['message'=>'User deleted'];

    }
}
