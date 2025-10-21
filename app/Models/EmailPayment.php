<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailPayment extends Model
{
    use HasFactory;

    protected $fillable = ['payment_id','user_id' ,'product_id' , 'product_name', 'quantity', 'amount', 'currency','message' , 'payer_name', 'payer_email', 'payment_status', 'payment_method','status','shipping_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subProduct()
    {
        return $this->belongsTo(SubProduct::class, 'product_id');
    }

    public function parts()
    {
        return $this->hasMany(PartsPayment::class);
    }
    
    public function textures()
    {
        return $this->hasMany(TexturesPayment::class);
    }





}
