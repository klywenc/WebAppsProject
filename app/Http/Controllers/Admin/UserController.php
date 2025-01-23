<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.suck', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create', ['roles' => ['admin', 'employee', 'user']]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,employee,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.suck')->with('success', 'Użytkownik został dodany.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user, 'roles' => ['admin', 'employee', 'user']]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,employee,user',
        ]);

        $user->update($request->only('name', 'email', 'role'));

        return redirect()->route('admin.users.suck')->with('success', 'Dane użytkownika zostały zaktualizowane.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.suck')->with('success', 'Użytkownik został usunięty.');
    }
}
