<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterLog extends Model
{
    use HasFactory;

    protected $table = 'parameter_logs';

    protected $fillable = [
        'item_type_id',
        'item_id',
        'parameter_group_id',
        'parameter_id',
        'parameter_name',
        'user_id',
        'action_type',
    ];
}
