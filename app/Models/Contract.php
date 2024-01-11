<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'insp_id',
        'sec_id',
        'sender',
        'reference_no',
        'additional_documents',
        'item_id',
        'item_type_id',
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
        'status',
    ];
}
