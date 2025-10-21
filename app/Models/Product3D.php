<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product3D extends Model
{
    use HasFactory;

    protected $table = 'products_3d';

    protected $fillable = ['name', 'price', 'model_id', 'desc', 'file', 'category3d_id' , 'video' , 'images','delivery_price','shipping_price'];

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'product_parts', 'product_id', 'part_id');
    }

    public function textures()
    {
        return $this->belongsToMany(Texture::class, 'product_textures', 'product_id', 'texture_id');
    }
    public function category()
    {
        return $this->belongsTo(category3d::class);
    }

}
