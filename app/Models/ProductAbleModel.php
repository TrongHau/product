<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAbleModel extends Model
{
    protected $table = 'product_able';
    protected $fillable = [
        'product_id',
        'product_able_type',
        'product_ables_id',
        'cost',
        'price',
        'price_floor',
        'count'
    ];
}
