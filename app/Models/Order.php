<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'email',
        'phone',
        'adress',
        'title',
        'price',
        'quantity',
        'image',
        'delivery_status',
        'food_id',
        'stock_insuffisant',
      
    ];
        public function food()
            {
                return $this->belongsTo(Food::class);
            }

}

