<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryModel extends Model
{
    protected $table = 'inventory';
    protected $fillable = [
        'warehouse_id',
        'product_id',
        'inv_number',
        'cost',
        'price',
        'price_floor',
    ];
    public function product()
    {
        return $this->belongsTo('App\Models\ProductModel', 'product_id');
    }
    public function warehouse()
    {
        return $this->belongsTo('App\Models\WarehouseModel', 'warehouse_id');
    }
}
