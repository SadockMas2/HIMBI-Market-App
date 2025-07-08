<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['food_id', 'quantity'];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
