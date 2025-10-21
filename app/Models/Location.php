<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country',
        'street',
        'house_number',
        'zip_code',
        'phone',
     	'first_name',
        'last_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}