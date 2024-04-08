<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role_User extends Model {
    protected $guarded = [
        'id',
    ];

    protected $table = 'role_user';
    public $timestamps = true;    

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Roles', 'role_id');
    }
}
