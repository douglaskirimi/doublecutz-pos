<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Category;
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
        $categories=Category::all();
        return view('users.create',compact('roles','categories'));
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
            'f_name' => 'required|min:3|unique:users|regex:/^[a-zA-Z ]+$/',
            'l_name' => 'required',
            'email' => 'required',
            'role_id' => 'required',
            // 'usergroup_id' => 'required',
            'password' => 'required|min:6',
            
        ]);

        $user = new User();
        $user->f_name = $request->f_name;
        $user->l_name = $request->l_name;
        $user->image="";
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        // $user->usergroup_id = $request->usergroup_id;
        // dd($request->password);
        $user->password=bcrypt($request->password);
        $user->save();

 
       // if( $user->save())
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
        // dd($id);
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
        // dd($request);
        $request->validate([
            'f_name' => 'required|min:3|regex:/^[a-zA-Z ]+$/',
            'l_name' => 'required|min:3|regex:/^[a-zA-Z ]+$/',
            'email' => 'required|email',
            'role_id' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->f_name = $request->f_name;
        $user->l_name = $request->l_name;
        $user->email = $request->email;
        // $user->mobile = $request->mobile;
        $user->role_id = $request->role_id;
        // $user->usergroup_id = 1;

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
