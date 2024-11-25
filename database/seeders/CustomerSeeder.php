<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Customer::factory(25)
            ->hasInvoices(10)
            ->create();

        Customer::factory(100)
            ->hasInvoices(5)
            ->create();

        Customer::factory(100)
            ->hasInvoices(3)
            ->create();

        Customer::factory(5)
            ->create();
    }
}
