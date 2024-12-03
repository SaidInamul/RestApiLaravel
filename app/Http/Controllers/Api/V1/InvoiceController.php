<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Invoice;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Filters\V1\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceResource;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Requests\V1\BulkStoreInvoiceRequest;
use App\Http\Requests\V1\BulkDestroyInvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filter = new InvoiceFilter();
        $queryItems = $filter->transform($request);

        if(count($queryItems) == 0) {
            return new InvoiceCollection(Invoice::paginate());
        }

        else {
            $invoices = Invoice::where($queryItems)->paginate();
            return new InvoiceCollection($invoices->appends($request->query()));
        }

        // return Invoice::all()->count();
    }

    public function bulkStore(BulkStoreInvoiceRequest $request)
    {
        //      
        if (Invoice::insert($request->toArray())) {
            $response = [
                'message' => 'New invoices added successfully'
            ];
        }

        else {
            $response = [
                'message' => 'Fail to add new invoices'
            ];
        }

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    public function bulkDestroy(BulkDestroyInvoiceRequest $request)
    {
        $ids = $request->validated()['ids'];
    
        // Perform the bulk delete
        $deletedCount = Invoice::destroy($ids);

        if ($deletedCount > 0) {
            $response = [
                'message' => 'Deleted successfully',
                'deleted_count' => $deletedCount
            ];
        }

        else {
            $response = [
                'message' => 'Deleted unsuccessfully',
                'deleted_count' => $deletedCount
            ];
        }
    
        return response()->json($response);
    }
}
