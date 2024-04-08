<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitModel extends Model
{
    protected $table = 'unit';
    protected $fillable = [
        'name',
    ];
}
