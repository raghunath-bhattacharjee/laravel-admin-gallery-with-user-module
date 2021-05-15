<?php

namespace App\Http\Controllers;

use App\User;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addUser()
    {
        $permissions = Permission::all();
        return view('admin.add-user', compact('permissions'));
    }


    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:1|max:255|unique:users,username,except,id',
            'first_name' => 'required|min:1|max:255',
            'last_name' => 'required|min:1|max:255',
            'email' => 'required|min:1|max:255',
            'status' => 'required|boolean',
            'user_type' => 'required',
            'password' => 'required|min:1|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();
        $user = $this->saveDetails($request, $user);
        $user->save();

        $request->session()->flash('alert-success', 'User successful created.');
        return redirect()->back();
    }

    public function showEditUser(User $user)
    {
        $permissions = Permission::all();
        return view('admin.edit_user', compact('user', 'permissions'));
    }

    public function updateUser(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:1|max:255',
            'first_name' => 'required|min:1|max:255',
            'last_name' => 'required|min:1|max:255',
            'email' => 'required|min:1|max:255',
            'status' => 'required|boolean',
            'user_type' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->saveDetails($request, $user);
        $user->save();
        $request->session()->flash('alert-success', 'User successful updated.');
        return redirect()->back();
    }

    private function saveDetails(Request $request, $user)
    {
        $user->username = $request->get('username');
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');

        $user->status = $request->get('status');
        $user->user_type = $request->get('user_type');
        $user->role = $request->get('role');

        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        return $user;
    }

    public function deleteUser(User $user, Request $request)
    {
        $user->delete();
        $request->session()->flash('alert-success', 'User successful deleted');
        return redirect()->back();
    }
}
