<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMain3D extends Model
{
    use HasFactory;

    protected $table = 'category_main_3d';

    protected $fillable = [
        'name',
        'desc',
        'file',
    ];

    public function Category3d()
    {
        return $this->hasMany(Category3d::class);
    }
}
