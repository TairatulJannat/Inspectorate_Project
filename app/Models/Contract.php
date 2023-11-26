<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'ltr_no_of_contract',
        'ltr_date_contract',
        'contract_no',
        'contract_date',
        'contract_state',
        'con_fin_year',
        'supplier_id',
        'contracted_value',
        'delivery_schedule',
        'currency_unit',
    ];
}
