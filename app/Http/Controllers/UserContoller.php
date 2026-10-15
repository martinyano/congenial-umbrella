<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rfid_uid' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'status' => 'nullable',
            'password' => 'rfid_only'
        ]);

        User::create([
            'name' => $request->name,
            'rfid_uid' => $request->rfid_uid,
            'email' => $request->email,
            'status' => $request->has('status') ? 'Visible' : 'NotVisible'
        ]);

        return redirect('/users')->with('status', 'User Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rfid_uid' => 'required|string|max:255',
            // added ,'.$user->id to ignore this user's email so validation doesn't lock you out
            'email' => 'required|email|unique:users,email,' . $user->id, 
            'status' => 'nullable' // Removed the invalid password rule from here
        ]);

        $user->update([
            'name' => $request->name,
            'rfid_uid' => $request->rfid_uid,
            'email' => $request->email,
            // Kept lowercase 'visible' / 'notvisible' to match your working store method
            'status' => $request->has('status') ? 'Visible' : 'NotVisible' 
        ]);

        return redirect('/users')->with('status', 'User updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/users')->with('status', 'User deleted successfully!');
    }
}
