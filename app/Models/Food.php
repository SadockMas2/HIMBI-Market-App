<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    
    protected $table = 'food';


     protected $fillable = [
        'title',
        'detail',
        'price',
        'image',
        'stock',
    ];

    public function stockRelation()
{
    return $this->hasOne(Stock::class, 'food_id');
}

        public function ingredients()
        {
            return $this->belongsToMany(Ingredient::class, 'food_ingredients')
                        ->withPivot('quantity_required', 'unit')
                        ->withTimestamps();
        }
        
        
        public function getAvailableStockAttribute()
        {
            // on calcule le nombre maximum de plats qu’on peut préparer selon les ingrédients disponibles
            $max = PHP_INT_MAX;

            foreach ($this->ingredients as $ing) {
                if ($ing->quantity_in_stock > 0 && $ing->pivot->quantity_required > 0) {
                    $possible = floor($ing->quantity_in_stock / $ing->pivot->quantity_required);
                    $max = min($max, $possible);
                } else {
                    $max = 0;
                    break;
                }
            }

            return $max;
        }





}
