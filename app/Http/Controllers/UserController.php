<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   

        if (Auth::user()->hasPermissionTo('view any users')) {
            //Show all users
            $users = User::with('roles','permissions')->latest()->paginate(10);
        }
        // } else if (Auth::user()->hasPermissionTo('view posts')){
        //     // Regular User/Author: Show only their own posts
        //     $users = User::where('user_id', Auth::id())
        //                  ->with('roles', 'permissions')
        //                  ->latest()
        //                  ->paginate(10);
        // }
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
    public function store(Request $request, User $user)
        {
            try {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|confirmed',
                    'role' => 'required|string'
                ]);

            } catch (ValidationException $e) {
                dd($e->errors());
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $user->assignRole($request->role);

            return redirect()->route('users.index')->with('success', 'User created successfully!');
        }
    public function show(User $user)
    {
        $roles = Role::all();
        return view('users.show', compact('user', 'roles'));
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
        // Define the validation rules for the incoming request data.
        $data = [
            'name' => 'required|string|max:255', // 'name' is required, must be a string, and have a maximum length of 255 characters.
            'role' => 'required|string|exists:roles,name', // 'role' is required, must be a string, and must exist in the 'roles' table under the 'name' column.
            'email' => [
                'nullable',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|confirmed', // 'password' is not required. If provided, it must match the value of the 'password_confirmation' field.
            ];

            try {
                // Validate the incoming request data against the defined rules.
                $validatedData = $request->validate($data);
            } catch (ValidationException $e) {
                // If validation fails, catch the ValidationException and dump the error messages for debugging.
                dd($e->errors());
            }

            // Initialize an array to hold the user data that will be updated.
            $userData = [
                'name' => $validatedData['name'], // Assign the validated 'name' to the $userData array.
            ];

            // Check if the 'email' key exists in the validated data (meaning an email was provided and passed validation).
            if (isset($validatedData['email'])) {
                $userData['email'] = $validatedData['email']; // Assign the validated 'email' to the $userData array.
            }

            // Check if the 'password' key exists in the validated data (meaning a password was provided and passed validation).
            if (isset($validatedData['password'])) {
                $userData['password'] = Hash::make($validatedData['password']); // Hash the validated 'password' and assign it to the $userData array.
            }

            // Update the user model with the validated data stored in the $userData array.
            $user->update($userData);

            $user->syncRoles([$validatedData['role']]);

            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        }
    public function destroy(User $user)
        {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully!');
        }
}
