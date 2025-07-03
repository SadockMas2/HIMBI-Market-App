<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServerOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'serveur_id',
        'table_id',
        'food_id',
        'quantite',
        'statut',
    ];

    public function serveur()
    {
        return $this->belongsTo(User::class, 'serveur_id','id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
    public function payments()
    {
        // Un ServerOrder a plusieurs paiements reliés via payments.order_id = server_orders.id
        return $this->hasMany(Payment::class, 'order_id', 'id');
    }

   
}

