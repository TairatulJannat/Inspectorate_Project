<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierSpecData extends Model
{
    use HasFactory;

    protected $fillable = [
        'parameter_group_id',
        'parameter_name',
        'parameter_value',
        'indent_id',
        'supplier_id',
        'tender_id',
    ];

    // Optional: Define relationships with other models
    public function parameterGroup()
    {
        return $this->belongsTo(ParameterGroup::class, 'parameter_group_id');
    }

    public function indent()
    {
        return $this->belongsTo(Indent::class, 'indent_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id');
    }
}
