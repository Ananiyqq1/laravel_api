<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Customer::factory(25)
            ->hasInvoices(10)
            ->create();

        \App\Models\Customer::factory(100)
            ->hasInvoices(5)
            ->create();

        \App\Models\Customer::factory(100)
            ->hasInvoices(3)
            ->create();

        \App\Models\Customer::factory(5)
            ->create();
    }
}
