<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // si tu utilises Laravel Sanctum

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les attributs assignables.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype', // si tu as ce champ pour distinguer admin, serveur, client, etc.
    ];

    /**
     * Les attributs cachés pour les tableaux (ex : lors de retour JSON).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
