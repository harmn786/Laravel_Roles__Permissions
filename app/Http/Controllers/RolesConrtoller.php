<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RolesConrtoller extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new middleware('permission:view roles', only:['index']),
            new middleware('permission:edit roles', only:['edit']),
            new middleware('permission:create roles', only:['create']),
            new middleware('permission:delete roles', only:['destroy']),
        ];
    }
    

    public function index(){
        $roles = Role::orderBy('name','ASC')->paginate(5);
        return view('roles.show',['roles'=>$roles]);
    }
    // function for create permission page
    public function create(){
        $permissions = Permission::orderBy('name','ASC')->get();
        return view('roles.create',['permissions'=>$permissions]);
    }
    // function for store permissions in db
    public function store(Request $request){
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|unique:roles|min:3'
        ]
        );
        if($validator->passes()){
            $role = Role::create(['name' => $request->name]);
            if(!empty($request->permission)){
                foreach($request->permission as $name){
                    $role->givePermissionTo($name);
                }
            }
            return redirect()->route('roles.show')->with('success','Role Created Successfully');
        }
        else{
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }
    // function for edit permission page
    public function edit($id){
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name','ASC')->get();
        return view('roles.edit',['role'=> $role, 'hasPermissions' => $hasPermissions, 'permissions' => $permissions]);
    }
    // function for update permissions in db
    public function update(Request $request, $id){
        $role = Role::findOrFail($id);
        $validator = Validator::make($request->all(),
        [
            'name' => 'required|min:3|unique:roles,name,'.$id.',id'
        ]
        );
        if($validator->passes()){
            $role->name = $request->name;
            $role->save();
            if(!empty($request->permission)){
                    $role->syncPermissions($request->permission);
            }
            else{
                $role->syncPermissions([]);
            }
            return redirect()->route('roles.show')->with('success','Roles Updated Successfully');
        }
        else{
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }
    // function for destroy permissions from db
    public function destroy(Request $request){
        $role = Role::find($request->id);
        if($role == null){
            session()->flash('error','Role not found in DB');
            return response()->json([
                'status'=> false
            ]);
        }
            $role->delete();
            session()->flash('success','Role Deleted Successfully');
            return response()->json([
                'status'=> true,
            ]);
    }
}
