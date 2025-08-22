<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;

    protected $fillable = ['food_id', 'type', 'quantity', 'created_at'];

            public function food()
        {
            return $this->belongsTo(Food::class);
        }

        public function ingredient()
        {
            return $this->belongsTo(Ingredient::class);
        }


}
