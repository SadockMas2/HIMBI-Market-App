<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_IN_PROGRESS = 'In Progress';

    protected $fillable = [
        'name', 'email', 'phone', 'adress', 'title',
        'price', 'quantity', 'image', 'delivery_status',
        'food_id', 'stock_insuffisant',
    ];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function setDeliveryStatusAttribute($value)
    {
        // Supprimer les espaces et sauts de ligne superflus
        $this->attributes['delivery_status'] = preg_replace('/\s+/', ' ', trim($value));
    }

    public function getDeliveryStatusAttribute($value)
    {
        return trim($value);
    }


}
