<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_type extends Model
{
    use HasFactory;

    protected $table = 'item_types';

    // public function prelimgeneral()
    // {
    //     return $this->belongsTo(PrelimGeneral::class);
    // }
    public function prelimgenerals()
    {
        return $this->hasMany(PrelimGeneral::class);
    }

    public function item()
    {
        return $this->hasOne(Items::class, 'item_type_id');
    }

    public function parameterGroup()
    {
        return $this->hasOne(ParameterGroup::class, 'item_type_id');
    }
}
