<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['nom_table', 'capacite', 'statut', 'description'];

    public function reservations()
    {
        return $this->hasMany(Book::class);
    }
}
