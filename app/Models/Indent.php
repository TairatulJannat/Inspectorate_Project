<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indent extends Model
{
    use HasFactory;

    public function tenders()
    {
        return $this->hasMany(Tender::class, 'reference_no', 'indent_reference_no');
    }
}
