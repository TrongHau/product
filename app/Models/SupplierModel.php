<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    protected $table = 'supplier';
    protected $fillable = [
        'user_id',
        'number_tax',
        'name',
        'email',
        'phone',
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
