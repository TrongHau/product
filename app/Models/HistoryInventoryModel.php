<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryInventoryModel extends Model
{
    protected $table = 'history_inventory';
    protected $fillable = [
        'inventory_id',
        'warehouse_id',
        'product_id',
        'inv_number',
        'action',
        'user_id'
    ];
}
