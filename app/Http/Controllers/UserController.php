<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function show(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }
    public function update(Request $request, User $user)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'roles' => 'required|array',
            ]);
    $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $user->syncRoles($request->roles);

            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        }
    public function destroy(User $user)
        {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully!');
        }
}
