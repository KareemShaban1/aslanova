<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image_url', 'price', '3d_name'];

    public function products()
    {
        return $this->belongsToMany(Product3D::class, 'product_parts', 'part_id', 'product_id');
    }
}
