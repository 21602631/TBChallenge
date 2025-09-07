<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Vendor;

class InvoiceService
{
    public function create(array $data): Invoice
    {
        if (!isset($data['due_date'])) {
            $data['due_date'] = $this->getDueDate($data['doc_date'], $data['vendor_id']);
        }
        return Invoice::create($data);
    }

    private function getDueDate(string $doc_date, int $vendor_id): ?string
    {
        $vendor = Vendor::find($vendor_id);
        if ($vendor && $vendor->payment_terms) {
            return date('Y-m-d', strtotime($doc_date . ' + ' . $vendor->payment_terms . ' days'));
        }
        return '';
    }
}
