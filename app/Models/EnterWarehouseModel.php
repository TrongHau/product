<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductModel;


class EnterWarehouseModel extends Model
{
    protected $table = 'enter_warehouse';
    protected $fillable = [
        'user_id',
        'warehouse_id',
        'supplier_id',
        'code_receipt',
        'shipment',
        'purchase_date',
        'expired_date',
        'receipt_created_date',
        'note',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Models\SupplierModel', 'supplier_id');
    }
    public function warehourse()
    {
        return $this->belongsTo('App\Models\WarehouseModel', 'warehouse_id');
    }
    public function product() {
        return $this->morphedByMany(ProductModel::class,
            'product_able',
            'product_able',
            'product_ables_id',
            'product_id',
            'id',
            'id');
    }
}
