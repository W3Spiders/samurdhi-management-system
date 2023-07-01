<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with(['gn_division'])->where(function (Builder $query) use ($search) {
            return $query->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%"); // Search by first name, last name.
        })->where('user_type', '!=', 'admin')->paginate(10); // Exclude admin user

        return Inertia::render('User/Index', ['filters' => $request->all('search', 'trashed'), 'users' => $users]);
    }

    public function show($id)
    {
        $user = User::with('gn_division')->find($id);

        return Inertia::render('User/Show', ['user' => $user]);
    }

    public function create()
    {
        return Inertia::render('User/Create');
    }

    public function edit($id)
    {

        $user = User::with('gn_division')->find($id);

        return Inertia::render('User/Create', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:15',
            'email' => 'required|max:50',
            'first_name' => 'required|max:50',
            'last_name' => 'required',
            'user_type' => 'required|in:admin,ds,gn,sn',
            'password' => 'required|min:8|max:10'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $new_user = new User();
        $new_user->user_type = $request['user_type'];
        $new_user->username = $request['username'];
        $new_user->email = $request['email'];
        $new_user->first_name = $request['first_name'];
        $new_user->last_name = $request['last_name'];
        $new_user->password = Hash::make($request['password']);

        $result = $new_user->Save();

        if ($result) {
            return Redirect::route('users.show', ['id' => $new_user->id])->with('success', 'User was created successfully');
        }
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);

        if (!$user) {
            return Redirect::back()->with('error', 'User doesn\'t exist');
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|max:15',
            'email' => 'required|max:50',
            'first_name' => 'required|max:50',
            'last_name' => 'required',
            'user_type' => 'required|in:admin,ds,gn,sn',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user->user_type = $request['user_type'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];

        if (isset($request['password'])) { // Update password only if provided
            $user->password = Hash::make($request['password']);
        }

        $result = $user->save();

        if ($result) {
            return Redirect::route('users.show', $user->id)->with('success', 'User was updated successfully');
        }
    }
}
