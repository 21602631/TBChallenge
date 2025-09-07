<?php

namespace App\Console\Commands;

use App\Http\Requests\CreateInvoice;
use App\Services\InvoiceService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImportInvoiceJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-invoice-json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import invoices from a JSON file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $json = Storage::disk('public')->get('invoices.json');
        $invoices = json_decode($json, true);
        $bar = $this->output->createProgressBar(count($invoices));
        $bar->start();

        $service = app(InvoiceService::class);
        $success = 0;
        $error = 0;
        $validation = 0;
        foreach ($invoices as $invoice) {
            $bar->advance();
            $validator = Validator::make($invoice, (new CreateInvoice())->rules());
            if ($validator->fails()) {
                $validation++;
                continue;
            }
            $service->create($validator->validated());
            $success++;
        }
        $bar->finish();
        $this->info("\n\nImport completed!\n\nInvoices Created: " . $success . "\nInvoices with Validation Errors: " . $validation . "\nInvoices with Other Errors: " . $error);
    }
}
