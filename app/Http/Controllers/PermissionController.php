<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware('permission:view permissions', only:['index']),
            new middleware('permission:edit permissions', only:['edit']),
            new middleware('permission:create permissions', only:['create']),
            new middleware('permission:delete permissions', only:['destroy']),
        ];
    }
    // function for show permission page
    public function index(){
        $permissions = Permission::orderBy('created_at')->paginate(5);
        return view('permissions.show',['permissions' => $permissions]);
    }
    // function for create permission page
    public function create(){
        return view('permissions.create');
    }
    // function for store permissions in db
    public function store(Request $request){
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|unique:permissions|min:3'
        ]
        );
        if($validator->passes()){
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.show')->with('success','Permission Created Successfully');
        }
        else{
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }
    // function for edit permission page
    public function edit($id){
        $permission = Permission::findOrFail($id);
        return view('permissions.edit',['permission' => $permission]);
        
    }
    // function for update permissions in db
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|min:3|unique:permissions,name,'.$id.',id'
        ]
        );
        if($validator->passes()){
            $permission = Permission::findOrFail($id);
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.show')->with('success','Permission Updated Successfully');
        }
        else{
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }
    // function for destroy permissions from db
    public function destroy(Request $request){
        $permission = Permission::find($request->id);
        if($permission == null){
            session()->flash('error','Permission not found in DB');
            return response()->json([
                'status'=> false
            ]);
        }
            $permission->delete();
            session()->flash('success','Permission Deleted Successfully');
            return response()->json([
                'status'=> true,
            ]);
    }
}
