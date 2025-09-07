<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Vendors\VendorsController;
use App\Http\Controllers\Invoices\InvoicesController;

Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Wrong credentials'], 401);
    }
    $token = $user->createToken('api-token')->plainTextToken;
    return response()->json(['token' => $token], 200);
})->name('login');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::group(['prefix' => 'vendors'], function () {
        Route::post('create', [VendorsController::class, 'create'])->name('vendors.create');
        Route::get('/{id}', [VendorsController::class, 'get'])->name('vendors.get');
        Route::get('/{id}/summary', [VendorsController::class, 'summary'])->name('vendors.summary');
    });
    Route::group(['prefix' => 'invoices'], function () {
        Route::post('create', [InvoicesController::class, 'create'])->name('invoices.create');
        Route::get('/', [InvoicesController::class, 'get'])->name('invoices');
    });
});