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

}
