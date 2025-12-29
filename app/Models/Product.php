<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];
    public function getImageAttribute($value)
{
    return $value ? asset('product/' . $value) : null;
}

}
