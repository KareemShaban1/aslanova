<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartsPaypal extends Model
{
    use HasFactory;

    protected $fillable = ['paypal_payment_id', 'name', 'price'];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
