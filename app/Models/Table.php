<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['nom_table', 'capacite', 'statut', 'description', 'serveur_id'];

            // Table.php
            public function reservation()
            {
                return $this->hasOne(Book::class, 'table_id'); // ou hasMany si plusieurs
            }

            public function commandes()
            {
                return $this->hasMany(ServerOrder::class, 'table_id');
            }
            
            public function serveur()
            {
                return $this->belongsTo(User::class, 'serveur_id');
            }

}
