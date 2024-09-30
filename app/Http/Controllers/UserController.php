<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [
            new middleware('permission:view users', only:['index']),
            new middleware('permission:edit users', only:['edit']),

        ];
    }
    public function index()
    {
        //
        $users = User::latest()->paginate(1);
        return view('users.show',['users'=>$users]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::orderBy('name','ASC')->get();
        return view('users.create',['roles'=> $roles]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         //
         $validator = Validator::make($request->all(),
         [
             'name'=>'required',
             'email' => 'required|email|unique:users,email',
             'password'=>'required|same:confirm_password',
             'confirm_password'=>'required'
         ]
         );
         if($validator->fails()){
             return redirect()->route('users.create')->withInput()->withErrors($validator);
         
             }
             $user = new User();
             $user->name = $request->name;
             $user->email = $request->email;
             $user->password = Hash::make($request->password);
             $user->save();
             $user->syncRoles($request->role);
             return redirect()->route('users.show')->with('success','User Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::findOrFail($id);
        $roles = Role::orderBy('name','ASC')->get();
        $hasRoles = $user->roles->pluck('id');
        return view('users.edit',['user'=>$user,'roles'=>$roles,'hasRoles'=>$hasRoles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(),
        [
            'name'=>'required',
            'email' => 'required|email|unique:users,email,'.$id.',id'
        ]
        );
        if($validator->fails()){
            return redirect()->route('users.edit')->withInput()->withErrors($validator);
        
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            $user->syncRoles($request->role);
            return redirect()->route('users.show')->with('success','User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $user = User::find($request->id);
        if($user == null){
            session()->flash('error','User not found in DB');
            return response()->json([
                'status'=> false
            ]);
        }
            $user->delete();
            session()->flash('success','User Deleted Successfully');
            return response()->json([
                'status'=> true,
            ]);
    }
}
