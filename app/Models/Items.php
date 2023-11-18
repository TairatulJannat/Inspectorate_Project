<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    public function item_type()
    {
        return $this->belongsTo(Item_type::class, 'item_type_id');
    }

    public function parameterGroup()
    {
        return $this->hasOne(ParameterGroup::class, 'item_id');
    }
}
