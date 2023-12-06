<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignParameterValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'parameter_group_id',
        'parameter_name',
        'parameter_value',
    ];

    public function parameterGroup()
    {
        return $this->belongsTo(ParameterGroup::class, 'parameter_group_id');
    }
}
