<?php

namespace App;

use App\Models\Inspectorate;
use Illuminate\Database\Eloquent\Model;

class dynamic_route extends Model
{
    public function role()
    {
    	return $this->belongsToMany(role::class, 'permission_roles','role_id');
    }

    public function menu() {
        return $this->belongsTo(ModelMenu::class,'id','menu_dynamic_route_id') ;
    }
    public function inspectorate()
    {
        return $this->hasMany(Inspectorate::class, 'inspectorate_id', 'id');
    }
    
}
