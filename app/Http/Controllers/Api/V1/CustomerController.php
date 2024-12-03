<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Filters\V1\CustomerFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filter = new CustomerFilter();
        $filterItems = $filter->transform($request);

        $includeInvoices = $request->query('includeInvoices');

        $customers = Customer::where($filterItems);

        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }

        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
        $includeInvoices = request()->query('includeInvoices');

        if ($includeInvoices) {
            $customer = $customer->loadMissing('invoices');
        }

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
        $customer = $customer->update($request->all()); //Update() return true

        if ($customer) {
           $response = [
            'message' => 'Customer updated successfully'
           ];
        }

        else {
            $response = [
                'message' => 'Fail to update'
            ];
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //

        $user = auth()->user();

        if ($user !== null && $user->tokenCan('delete')) {
            if ($customer->delete()) {
                $response = [
                    'message' => 'Customer deleted successfully'
                ];
            }
    
            else {
                $response = [
                    'message' => 'Fail to delete'
                ];
            }
        }

        else {
            $response = [
                'message' => 'Unauthorized action'
            ];
        }

        return response()->json($response);
    }
}
