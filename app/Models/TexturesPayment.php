<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TexturesPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_payment_id',
        'name',
        'price',
    ];

    public function payment()
    {
        return $this->belongsTo(EmailPayment::class , 'email_payment_id');
    }
}
