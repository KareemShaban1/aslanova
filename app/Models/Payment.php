<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'paypal_payments';
    protected $fillable = ['payment_id','user_id' , 'product_name', 'quantity', 'amount', 'currency','location' , 'payer_name', 'payer_email', 'payment_status', 'payment_method','status','shipping_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parts()
    {
        return $this->hasMany(PartsPaypal::class, 'paypal_payment_id');
    }

    public function textures()
    {
        return $this->hasMany(TexturesPaypal::class, 'paypal_payment_id');
    }
}
