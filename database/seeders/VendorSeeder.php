<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::create([
            'name' => 'ACME Corp',
            'vat_number' => 'BE123456789',
            'payment_terms' => 30
        ]);

        Vendor::create([
            'name' => 'M&M Inc',
            'vat_number' => 'BE987654321',
            'payment_terms' => 3
        ]);
        Vendor::factory()->count(10)->create();
    }
}
