<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelMenu extends Model
{
    protected $table = 'master_menu';

    public function childs() {
        return $this->hasMany('App\ModelMenu','menu_parent_id','id') ;
    }
    public function parent() {
        return $this->hasOne('App\ModelMenu','id','menu_parent_id') ;
    }
    public function route() {
        return $this->hasOne('App\dynamic_route','id','menu_dynamic_route_id') ;
    }
}
