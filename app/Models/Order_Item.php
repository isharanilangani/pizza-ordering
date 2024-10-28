<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Item extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $primaryKey = 'pk_id';
    protected $fillable = [
        'fk_order_id',
        'fk_pizza_id',
        'quantity',
        'price',
    ];

    // Relationship: An order item belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class, 'fk_order_id');
    }

    // Relationship: An order item belongs to a pizza
    public function pizza()
    {
        return $this->belongsTo(Pizza::class, 'fk_pizza_id');
    }
}
