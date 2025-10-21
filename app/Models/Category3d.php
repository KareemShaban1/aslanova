<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category3d extends Model
{
    protected $fillable = ['name', 'desc', 'file','categorymain3d_id'];


    public function products()
    {
        return $this->hasMany(Product3D::class);
    }

    public function categorymain3d()
    {
        return $this->belongsTo(CategoryMain3D::class);
    }
}
