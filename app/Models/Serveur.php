<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serveur extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'email',
        'phone',
        'adress',
        'image',
        
    ];
}
