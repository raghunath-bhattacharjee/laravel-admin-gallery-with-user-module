<?php

namespace App\Http\Controllers;
use App\User;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
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

    public function index()
    {
        $permissions = Permission::all();
        return view('role.permissions', compact('permissions'));
    }

    public function createRoll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|min:1|max:255|unique:permissions,role,except,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $rolePermission = new permission();
        $rolePermission->role = $request->get('role');
        $rolePermission->permissions = $request->get('permissions');
        $rolePermission->user_id = Auth::id();

        $rolePermission->save();

        $request->session()->flash('alert-success', 'User successful created.');
        return redirect()->back();
    }

    public function deleteRole(Permission $role, Request $request)
    {
        User::where('role', $role->id)->update(['role' => Permission::DEFAULT]);

        $role->delete();
        $request->session()->flash('alert-success', 'User successful deleted');
        return redirect()->back();
    }
}
