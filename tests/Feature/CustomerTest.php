<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_create_customer () : void {
        // Create an customer first
        $customer = Customer::factory()->create();

        // Create a invoice associated with the customer
        $invoiceData = [
            'customer_id' => $customer->id,
            'amount' => '500',
            'status' => 'B',
            'billed_date' => now(),
            'paid_date' => null,
        ];

        $invoice = Invoice::create($invoiceData);

        // Assert that the invoice exists in the database
        $this->assertDatabaseHas('invoices', [
            'amount' => $invoiceData['amount'],
            'customer_id' => $customer->id,
        ]);

        // Assert that the invoice is associated with the customer
        $this->assertTrue($invoice->customer->is($customer));
    }
}
