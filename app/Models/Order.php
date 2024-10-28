<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'pk_id';
    protected $fillable = [
        'fk_customer_id',
        'total_price',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'fk_customer_id');
    }

    public function orderItems()
    {
        return $this->hasMany(Order_Item::class, 'fk_order_id');
    }
}
