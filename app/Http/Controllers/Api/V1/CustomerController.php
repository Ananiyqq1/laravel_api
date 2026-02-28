<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new \App\Filters\V1\CustomersFilter();
        $queryItems = $filter->transform($request); // [['column', 'operator', 'value']]

        $includeInvoices = $request->query('includeInvoices');

        $customers = Customer::where($queryItems);

        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }

        return new \App\Http\Resources\Api\V1\CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\Api\V1\StoreCustomerRequest $request)
    {
        return new \App\Http\Resources\Api\V1\CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $includeInvoices = request()->query('includeInvoices');

        if ($includeInvoices) {
            return new \App\Http\Resources\Api\V1\CustomerResource($customer->loadMissing('invoices'));
        }

        return new \App\Http\Resources\Api\V1\CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\Api\V1\UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
    }
}
