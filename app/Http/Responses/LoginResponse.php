<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\Request;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return redirect()->route('clients.index');
        }

        $client = \App\Models\Client::where('user_id', $user->id)->first();

        if ($client) {
            return redirect()->route('clients.show', $client);
        }

        return redirect('/'); 
    }
}