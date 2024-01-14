<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftContract extends Model
{
    use HasFactory;
    protected $table='draft_contracts';
    protected $fillable=[];
}
