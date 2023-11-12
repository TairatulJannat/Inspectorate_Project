<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrelimGeneral extends Model
{
    use HasFactory;
    protected $table = 'prelim_gen_specs';
    protected $fillable = [];


    // public function inspection()
    // {
    //     return $this->belongsTo(Inspection::class, 'insp_id');
    // }

    // public function item()
    // {
    //     return $this->belongsTo(Item::class, 'item_id');
    // }

    // public function itemType()
    // {
    //     return $this->belongsTo(ItemType::class, 'item_type_id');
    // }
}


