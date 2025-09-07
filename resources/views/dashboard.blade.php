<!doctype html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <title>Microservice Challenge</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap 5 CSS (CDN) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">Vendor's Dashboard</h1>
        <div class="accordion" id="basicAccordion">
            @foreach($vendors as $vendor)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $vendor->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $vendor->id }}"
                        aria-expanded="false" aria-controls="collapse{{ $vendor->id }}">
                        {{ $vendor->name }}
                    </button>
                </h2>
                <div id="collapse{{ $vendor->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $vendor->id }}"
                    data-bs-parent="#basicAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card mb-3 widget-chart text-left">
                                    <div>Total Invoices</div>
                                    <div>{{ $vendor->summary['total_invoices'] }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card mb-3 widget-chart text-left">
                                    <div>Total Amount</div>
                                    <div>{{ $vendor->summary['total_amount'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="card mb-3 widget-chart text-left">
                                    <div>Pending Invoices</div>
                                    <div>{{ $vendor->summary['pending_invoices'] }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card mb-3 widget-chart text-left">
                                    <div>Pending Amount</div>
                                    <div>{{ $vendor->summary['pending_amount'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="card mb-3 widget-chart text-left">
                                    <div>Paid Invoices</div>
                                    <div>{{ $vendor->summary['paid_invoices'] }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card mb-3 widget-chart text-left">
                                    <div>Paid Amount</div>
                                    <div>{{ $vendor->summary['paid_amount'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>