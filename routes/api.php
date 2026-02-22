<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(
    ['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'],
    function () {
        Route::apiResource('customers', \App\Http\Controllers\Api\V1\CustomerController::class);
        Route::apiResource('invoices', \App\Http\Controllers\Api\V1\InvoiceController::class);

        Route::post('invoices/bulk', [\App\Http\Controllers\Api\V1\InvoiceController::class, 'bulkStore']);
    }
);