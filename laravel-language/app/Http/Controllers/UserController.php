<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        User::create($request->all());

        return redirect()->route('users.index', ['lang' => app()->getLocale()])
            ->with('success', __('User created successfully.'));
    }

    // Route Model Binding භාවිතා කරන්න
    public function edit($lang, User $user) // lang සහ User model එකතු කරන්න
    {
        return view('users.edit', compact('user'));
    }

    // Route Model Binding භාවිතා කරන්න
    public function update(Request $request, $lang, User $user) // lang සහ User model එකතු කරන්න
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user->update($request->all());

        return redirect()->route('users.index', ['lang' => app()->getLocale()])
            ->with('success', __('User updated successfully.'));
    }

    // Route Model Binding භාවිතා කරන්න
    public function destroy($lang, User $user) // lang සහ User model එකතු කරන්න
    {
        $user->delete();

        return redirect()->route('users.index', ['lang' => app()->getLocale()])
            ->with('success', __('User deleted successfully.'));
    }
}