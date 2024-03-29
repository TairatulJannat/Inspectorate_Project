<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignParameterValue extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function parameterGroup()
    {
        return $this->belongsTo(ParameterGroup::class, 'parameter_group_id');
    }
}
