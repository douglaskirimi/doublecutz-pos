<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
       //return response()->json(Auth::user()->permissions);
        $users = User::with('role')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ///return response()->json($request);
        $request->validate([
            'f_name' => 'required|min:3|unique:users|regex:/^[a-zA-Z ]+$/',
            'l_name' => 'required',
            'email' => 'required',
            'role_id' => 'required',
            'usergroup_id' => 'required',
            
        ]);
  

        $user = new user();
        $user->f_name = $request->f_name;
        $user->l_name = $request->l_name;
        $user->image="";
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->usergroup_id = $request->usergroup_id;
        $user->password=bcrypt("password");
 
       if( $user->save())
            return redirect()->back()->with('message', 'User Created Successfully');
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
        $roles=Role::all();
        $user = User::with('role')->findOrFail($id);
        return view('users.edit', compact('user','roles'));
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
            'address' => 'required|min:3',
            'mobile' => 'required|min:3|digits:10',
            'details' => 'required|min:3|',
            'previous_balance' => 'min:3',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->address = $request->address;
        $user->mobile = $request->mobile;
        $user->details = $request->details;
     
        $user->save();

        return redirect()->back()->with('message', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back();

    }
}
