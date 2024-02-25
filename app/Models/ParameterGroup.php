<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterGroup extends Model
{
    protected $guarded = ['id'];

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

    public function assignParameterValues()
    {
        return $this->hasMany(AssignParameterValue::class, 'parameter_group_id');
    }

    public function supplierSpecData()
    {
        return $this->hasMany(SupplierSpecData::class, 'parameter_group_id');
    }
}
