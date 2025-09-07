<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

class Vendor extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa (mass assignment).
     */
    protected $fillable = [
        'name',
        'vat_number',
        'payment_terms',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function summary(): array
    {
        $invoices = $this->invoices();

        $total_invoices = (clone $invoices)->count();
        $total_amount   = (clone $invoices)->sum('ammount');

        $pending_invoices = (clone $invoices)->where('status', 'pending')->count();
        $pending_amount   = (clone $invoices)->where('status', 'pending')->sum('ammount');

        $paid_invoices = (clone $invoices)->where('status', 'paid')->count();
        $paid_amount   = (clone $invoices)->where('status', 'paid')->sum('ammount');

        return [
            'total_invoices'    => $total_invoices,
            'total_amount'      => $total_amount,
            'pending_invoices'  => $pending_invoices,
            'pending_amount'    => $pending_amount,
            'paid_invoices'     => $paid_invoices,
            'paid_amount'       => $paid_amount,
        ];
    }
}
