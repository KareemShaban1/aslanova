<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['name', '3d_name',  'order', 'parent_id'];

    public function textures()
    {
        return $this->hasMany(Texture::class);
    }

    public function parent()
    {
        return $this->belongsTo(Material::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Material::class, 'parent_id');
    }
}
