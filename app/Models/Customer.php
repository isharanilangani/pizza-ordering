<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'pk_id';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    // Relationship: A customer can have many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
