<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Dis à Laravel d'utiliser la table 'bookings'
    protected $table = 'bookings';
}
