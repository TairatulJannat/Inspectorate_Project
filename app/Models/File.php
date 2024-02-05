<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',  // Add any other attributes that you want to allow mass assignment for
        'path',
        'doc_type_id',
        'reference_no',
        'created_at',
        'updated_at',
        'section_id',
        'inspectorate_id',
       
    ];
}
