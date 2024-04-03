<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HandleUserController extends Controller
{
    // Show all the registered users
    public function show(): View
    {
        $users = User::select('id', 'name', 'email')->where('role', 'user')->paginate(7);

        return view('admin.viewusers', ['users' => $users]);
    }

    // Get user's information to update it
    public function update($id): View
    {
        $user = User::find($id)->only('id', 'name', 'email');
        return view('admin.updateuser', ['user' => $user]);
    }

    // Update user's information 
    public function updateUser(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user = User::find($id);
        $user->update(['name' => $request->name]);

        return redirect(route('view.users'));
    }
}
