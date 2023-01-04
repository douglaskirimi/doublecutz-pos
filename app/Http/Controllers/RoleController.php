<?php

namespace App\Http\Controllers;

use App\Module;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules=Module::all();
        return view('role.create',compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:roles|regex:/^[a-zA-Z ]+$/',
            'can_view' => 'required',
            'can_create' => 'required',
            'can_update' => 'required',
            'can_delete' => 'required',
           

        ]);

        // $user = new user();
        // $user->name = $request->name;
        // $user->address = $request->address;
        // $user->mobile = $request->mobile;
        // $user->details = $request->details;
 
        // $user->save();
        $role=new Role();
        $role->name=$request->name;
        if($role->save()){
            $modules=$request->module_id;
            foreach($modules as $key=>$module){
                
                $permission=new Permission();
                $permission->module_id=$module;
                $permission->role_id=$role->id;
                $permission->can_view=$request->can_view[$key];
                $permission->can_create=$request->can_create[$key];
                $permission->can_update=$request->can_update[$key];
                $permission->can_delete=$request->can_delete[$key];
                $permission->save();
            }
               
        }
  
        return redirect()->back()->with('message', 'Role Created Successfully');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permissions=Permission::with('module')->where('role_id',$id)->get();
       // return response()->json($permissions);
        $role = Role::findOrFail($id);
        return view('role.edit', compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|regex:/^[a-zA-Z ]+$/',
            'can_view' => 'required',
            'can_create' => 'required',
            'can_update' => 'required',
            'can_delete' => 'required',
           

        ]);

        $role=Role::findOrFail($id);
        $role->name=$request->name;
        if($role->save()){
            $modules=$request->module_id;

            foreach($modules as $key=>$module){
                
                $permission=Permission::where('role_id',$id)->where('module_id',$module)->first();
              //return response()->json($request);
                $permission->module_id=$module;
                $permission->role_id=$role->id;
                $permission->can_view=$request->can_view[$key];
                $permission->can_create=$request->can_create[$key];
                $permission->can_update=$request->can_update[$key];
                $permission->can_delete=$request->can_delete[$key];
                $permission->update();
            }
               
        }

        return redirect()->back()->with('message', 'Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Role::find($id);
        $user->delete();
        return redirect()->back()->with('message','Role Deleted Successfully');

    }
}
