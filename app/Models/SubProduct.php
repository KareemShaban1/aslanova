<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class SubProduct extends Model
{
	use HasFactory;
    protected $fillable = 
    [
        'product_id',
        'Width',
        'Height',
        'Thickness',
        'capital',
        'quantity',
        'type',
        'file',
        'desc',
        'price',
        'name',
        'color',
        'video',
        'images','delivery_price','shipping_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function emailPayments()
    {
        return $this->hasMany(EmailPayment::class, 'product_id');
    }
}