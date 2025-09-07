<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVendor;
use App\Models\Invoice;
use App\Models\Vendor;
use Exception;

class VendorsController extends Controller
{
    function create(CreateVendor $request)
    {
        try {
            $vendor = Vendor::create($request->validated());
            return response()->json([
                'response' => 'success',
                'data' => $vendor
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Error creating vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function get($id)
    {
        try {
            $vendor = Vendor::find($id);
            if (!$vendor) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Vendor not found'
                ], 404);
            }
            return response()->json([
                'response' => 'success',
                'data' => $vendor
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Error creating vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    function summary($id)
    {
        try {
            $vendor = Vendor::find($id);
            if (!$vendor) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Vendor not found'
                ], 404);
            }
            return response()->json([
                'response' => 'success',
                'data' => [
                    'vendor' => $vendor,
                    'summary' => $vendor->summary()
                ]
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Error creating vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
