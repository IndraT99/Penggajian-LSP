<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Validation\Rule; 
use Illuminate\Validation\Rules\Password; 

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)], 
            'roles' => 'required|array', 
            'roles.*' => 'exists:roles,id', 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach($request->roles);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User baru berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return redirect()->route('admin.users.edit', $user);
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)], 
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Data User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        if ($user->hasRole('admin') && User::role('admin')->count() === 1) {
             return redirect()->route('admin.users.index')
                             ->with('error', 'Tidak bisa menghapus admin terakhir.');
        }

        try {
            $user->roles()->detach();
            $user->delete(); 

            return redirect()->route('admin.users.index')
                             ->with('success', 'User berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Terjadi kesalahan saat menghapus user: ' . $e->getMessage());
        }
    }
}