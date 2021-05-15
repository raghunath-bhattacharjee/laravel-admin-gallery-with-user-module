<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
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
        if (!Auth::user() || !Auth::user()->isSuperUser()) {
            return redirect('admin/profile');
        } else {
            $users = User::whereUserType(1)->get();
            return view('admin.home', compact('users'));
        }
    }

    public function showProfile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::find(Auth::id());
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->save();

        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
            $user->save();
            Auth::logout();
        }

        $request->session()->flash('alert-success', 'Profile successful updated!');
        return redirect()->back();
    }
}
