<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user->usertype === 'serveur') {
            return redirect()->intended('/serveur/board');
        } elseif ($user->usertype === 'admin') {
            return redirect()->intended('/home');
        }

        return redirect()->intended('/home');
    }
}
