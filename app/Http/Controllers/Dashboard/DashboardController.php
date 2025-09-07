<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Vendor;

class DashboardController extends Controller
{
    function dashboard() {
        $vendors = Vendor::all();
        foreach ($vendors as $vendor) {
            $vendor->summary = $vendor->summary();
        }
        return view('dashboard', compact('vendors'));
    }
}
