<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'serveur_id',
        'amount',
        'payment_date',
        'payment_method',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function serveur()
    {
        return $this->belongsTo(User::class, 'serveur_id');
    }

    
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }



}
