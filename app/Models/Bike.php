<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bike extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'model',
        'price_per_hour',
        'status',
        'stock',
        'colour',
        'img_route',
        'size',
    ];

    function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
