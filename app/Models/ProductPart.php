<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPart extends Model
{
    use HasFactory;

    protected $table = 'product_parts';

    protected $fillable = [
        'product_id',
        'part_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product3D::class, 'product_id');
    }

    public function part()
    {
        return $this->belongsTo(Part::class, 'part_id');
    }
}
