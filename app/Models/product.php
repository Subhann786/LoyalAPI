<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $primaryKey = 'product_id';
    protected $fillable = [
        'image',
        'name',
        'price',
        'points',
        'description',
    ];
}