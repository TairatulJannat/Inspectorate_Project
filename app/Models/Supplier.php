<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'insp_id',
        'firm_name',
        'principal_name',
        'address_of_local_agent',
        'address_of_principal',
        'contact_no',
        'email',
        'created_by',
    ];
}
