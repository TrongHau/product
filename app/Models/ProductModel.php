<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'product';
    protected $fillable = [
        'name',
        'parent',
        'status',
        'sku',
        'barcode',
        'weight',
        'category_id',
        'unit_id',
        'branch_id',
        'user_id',
        'description',
        'tag_live_stream',
        'properties',
        'image',
        'cost',
        'price',
        'is_deleted',
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function Category()
    {
        return $this->belongsTo('App\Models\CategoryModel', 'category_id');
    }
    public function Branch()
    {
        return $this->belongsTo('App\Models\BranchModel', 'branch_id');
    }
    public function Unit()
    {
        return $this->belongsTo('App\Models\UnitModel', 'unit_id');
    }
}
