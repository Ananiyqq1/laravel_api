<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new \App\Filters\V1\InvoicesFilter();
        $queryItems = $filter->transform($request); // [['column', 'operator', 'value']]

        if (count($queryItems) == 0) {
            return new \App\Http\Resources\Api\V1\InvoiceCollection(Invoice::paginate());
        } else {
            $invoices = Invoice::where($queryItems)->paginate();
            return new \App\Http\Resources\Api\V1\InvoiceCollection($invoices->appends($request->query()));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\Api\V1\StoreInvoiceRequest $request)
    {
        return new \App\Http\Resources\Api\V1\InvoiceResource(Invoice::create($request->all()));
    }

    public function bulkStore(\App\Http\Requests\Api\V1\BulkStoreInvoiceRequest $request)
    {
        $bulk = collect($request->all())->map(function ($item, $key) {
            return \Illuminate\Support\Arr::except($item, ['customerId', 'billedDate', 'paidDate']);
        });

        Invoice::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new \App\Http\Resources\Api\V1\InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\Api\V1\UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
    }
}
