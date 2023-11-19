<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterGroup extends Model
{
    protected $fillable = [
        'name',
        'inspectorate_id',
        'section_id',
        'item_id',
        'item_type_id',
        'description',
        'status',
    ];

    // Define relationships
    public function inspectorate()
    {
        return $this->belongsTo(Inspectorate::class, 'inspectorate_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }

    public function itemType()
    {
        return $this->belongsTo(Item_type::class, 'item_type_id');
    }
}
