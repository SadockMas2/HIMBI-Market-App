<?php

// app/Models/Book.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'name',
        'phone',
        'guest',
        'date',
        'time',
        'payment_status',
        'table_id',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }


    
    public function payments()
    {
        return $this->hasMany(Payment::class, 'book_id', 'id');
    }

   

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id'); // ou 'client_id' selon ta table
    }



}


