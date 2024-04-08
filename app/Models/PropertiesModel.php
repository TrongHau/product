<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertiesModel extends Model
{
    protected $table = 'properties';
    protected $fillable = [
        'product_id',
        'user_id',
        'name',
        'value',
    ];
}
