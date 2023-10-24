<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    public function user()
    {
        return $this->hasOne(User::class);
    }


    public function permission()
    {
    	return $this->belongsToMany(dynamic_route::class, 'permission_roles','route_id');
    }
}
