<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTexture extends Model
{
    use HasFactory;

    protected $table = 'product_textures';

    protected $fillable = [
        'product_id',
        'texture_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product3D::class, 'product_id');
    }

    public function texture()
    {
        return $this->belongsTo(Texture::class, 'texture_id');
    }
}
