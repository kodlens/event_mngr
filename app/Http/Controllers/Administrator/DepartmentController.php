<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Department;

class DepartmentController extends Controller
{
    //

    public function index(){
        return view('administrator.department.department-index');
    }

    public function show($id){
        return Department::find($id);
    }

    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);
        return Department::where('code', 'like', $req->code . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
    }

    public function store(Request $req){

        $req->validate([
            'code' => ['required', 'unique:departments'],
            'department' => ['required'],
        ]);

        Department::create([
            'code' => strtoupper($req->code),
            'department' => strtoupper($req->department),
            'active' => $req->active,
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){
        $req->validate([
            'code' => ['required', 'unique:departments,code,'.$id.',department_id'],
            'department' => ['required']
        ]);

        $data = Department::find($id);
        $data->code = strtoupper($req->code);
        $data->department = strtoupper($req->department);
        $data->active = $req->active;
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }

    public function setACtive($id){

        Department::where('active', 1)
            ->update([
                'active' => 0
            ]);

        Department::where('department_id', $id)
            ->update([
                'active' => 1
            ]);

        return response()->json([
            'status' => 'active'
        ], 200);
    }

    public function destroy($id){
        Department::destroy($id);
        return response()->json([
            'status' => 'deleted'
        ], 200);
    }


}
