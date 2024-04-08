<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseModel extends Model
{
    protected $table = 'warehouse';
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'contact',
        'is_deleted',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
