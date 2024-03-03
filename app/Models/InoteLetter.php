<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InoteLetter extends Model
{
    use HasFactory;
    protected $fillable = [
        'inote_letter_id', // Add this line
        // Add other fields that are mass assignable
        'book_no',
        'set_no',
        'copy_number',
        'copy_no',
        'visiting_letter_no',
        'contract_reference_no',
        'inote_reference_no',
        'indent_reference_no',
        'supplier_info',
        'sender_id',
        'cahidakari',
        'visiting_process',
        'status',
        'punishment',
        'slip_return',
        'serial_1',
        'serial_2to4',
        'serial_5',
        'serial_6',
        'serial_7',
        'serial_8',
        'serial_9',
        'serial_10',
        'serial_11',
        'serial_12',
        'serial_13',
        'body_info',
        'station',
        'date',
    ];
}