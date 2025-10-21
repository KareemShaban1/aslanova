<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Texture extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'price','base_color', 'glossiness', 'material_id'];

    public function products()
    {
        return $this->belongsToMany(Product3D::class, 'product_textures', 'texture_id', 'product_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}