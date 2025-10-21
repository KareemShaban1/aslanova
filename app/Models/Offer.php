<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'name',
        'price',
        'old_price',
        'description','delivery_price','shipping_price'
    ];
}
