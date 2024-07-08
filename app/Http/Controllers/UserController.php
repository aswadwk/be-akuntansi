<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'permissions'])
            ->paginate(10);

        return inertia('User/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return inertia('User/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:strict', 'max:255', 'min:3'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'string', 'same:password'],
            'role' => ['required', 'in:finance,owner,staff'],
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $user->assignRole($request->role);

            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'User created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create user.');

            throw $th;
        }
    }
}
