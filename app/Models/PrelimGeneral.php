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

    public function item_type()
    {
        return $this->belongsTo(Item_type::class);
    }

    // public function itemType()
    // {
    //     return $this->belongsTo(ItemType::class, 'item_type_id', 'id');
    // }

    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }
    // public function itemType()
    // {
    //     return $this->belongsTo(ItemType::class, 'item_type_id');
    // }
}