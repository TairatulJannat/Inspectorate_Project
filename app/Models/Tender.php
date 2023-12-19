<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;

    protected $table = 'tenders';
    protected $fillable = [];
    protected $casts = [
        'additional_documents' => 'json',
    ];

    public function indent()
    {
        return $this->belongsTo(Indent::class, 'indent_reference_no', 'reference_no');
    }
}
