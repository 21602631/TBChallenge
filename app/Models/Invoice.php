<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa (mass assignment).
     */
    protected $fillable = [
        'invoice_number',
        'vendor_id',
        'doc_date',
        'due_date',
        'status',
        'ammount'
    ];
}
