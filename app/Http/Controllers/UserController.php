<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;


class UserController extends Controller
{
    public function create(Client $client)
    {
        return view('clients.users.create', compact('client'));
    }

    public function store(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = new User($validated);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = bcrypt($validated['password']);
        $user->role = 'user'; // o como lo necesites
        $user->save();

        $client->user_id = $user->id;
        $client->save();

        return redirect()->route('clients.show', $client)->with('success', 'Usuario creado');
    }
}
