<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInvoice;
use App\Models\Invoice;
use App\Models\Vendor;
use App\Services\InvoiceService;
use Exception;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    function create(CreateInvoice $request, InvoiceService $InvoiceService)
    {
        try {
            $invoice = $InvoiceService->create($request->validated());
            return response()->json([
                'response' => 'success',
                'data' => $invoice
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Error creating Invoice',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function getDueDate($doc_date, $vendor_id)
    {
        $due_date = null;
        $vendor = Vendor::find($vendor_id);
        if (isset($vendor) && isset($vendor->payment_terms)) {
            $due_date = date('Y-m-d', strtotime($doc_date . ' + ' . $vendor->payment_terms . ' days'));
        }
        return $due_date;
    }

    function get(Request $request)
    {
        try {
            $invoices = Invoice::query();
            if (isset($request->status)) {
                if (is_array($request->status)) {
                    $invoices = $invoices->whereIn('status', $request->status);
                } else {
                    $invoices = $invoices->where('status', $request->status);
                }
            }
            if (isset($request->vendor_id)) {
                $invoices = $invoices->where('vendor_id', $request->vendor_id);
            }
            return response()->json([
                'response' => 'success',
                'invoices' => $invoices->select('invoice_number', 'vendor_id', 'ammount', 'doc_date', 'due_date', 'status')->get()
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Error getting Invoice',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
