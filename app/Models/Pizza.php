<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $primaryKey = 'pk_id';
    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    // Relationship: A pizza can be in many order items
    public function orderItems()
    {
        return $this->hasMany(Order_Item::class);
    }
}
