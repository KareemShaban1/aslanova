<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'desc',
        'type',
        'file',
        'Thickness',
        'Width',
        'Height',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function SubProduct()
    {
        return $this->hasMany(SubProduct::class);
    }
}
