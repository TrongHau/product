<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {
    protected $guarded = [
        'id',
    ];

    protected $table = 'roles';
    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function permissions() {
        return $this->morphToMany('App\Models\Permissions', 'permission_role');
    }

    public function users() {
        return $this->morphToMany('App\Models\Users', 'role_user');
    }

}
