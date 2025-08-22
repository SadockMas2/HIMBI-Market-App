<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name', 'quantity_in_stock','unit',];
    

        public function foods()
        {
            return $this->belongsToMany(Food::class, 'food_ingredients')
                        ->withPivot('quantity_required', 'unit')
                        ->withTimestamps();
        }


}

