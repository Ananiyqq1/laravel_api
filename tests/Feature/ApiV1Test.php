<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class ApiV1Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        Sanctum::actingAs($user, ['create', 'update', 'delete']);
    }

    public function test_can_list_customers()
    {
        Customer::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/customers');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    public function test_can_create_customer()
    {
        $data = [
            'name' => 'John Doe',
            'type' => 'I',
            'email' => 'john@example.com',
            'address' => '123 Main St',
            'city' => 'London',
            'state' => 'Greater London',
            'postalCode' => 'SW1A 1AA'
        ];

        $response = $this->postJson('/api/v1/customers', $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'John Doe');

        $this->assertDatabaseHas('customers', ['email' => 'john@example.com']);
    }

    public function test_can_update_customer()
    {
        $customer = Customer::factory()->create(['name' => 'Old Name']);

        $response = $this->patchJson("/api/v1/customers/{$customer->id}", [
            'name' => 'New Name'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'New Name']);
    }

    public function test_can_delete_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->deleteJson("/api/v1/customers/{$customer->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }

    public function test_can_list_invoices()
    {
        Invoice::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/invoices');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_create_invoice()
    {
        $customer = Customer::factory()->create();
        $data = [
            'customerId' => $customer->id,
            'amount' => 150.50,
            'status' => 'B',
            'billedDate' => '2026-02-28 10:00:00'
        ];

        $response = $this->postJson('/api/v1/invoices', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('invoices', ['amount' => 150.50]);
    }

    public function test_can_update_invoice()
    {
        $invoice = Invoice::factory()->create(['amount' => 100]);

        $response = $this->patchJson("/api/v1/invoices/{$invoice->id}", [
            'amount' => 200
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('invoices', ['id' => $invoice->id, 'amount' => 200]);
    }

    public function test_can_delete_invoice()
    {
        $invoice = Invoice::factory()->create();

        $response = $this->deleteJson("/api/v1/invoices/{$invoice->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('invoices', ['id' => $invoice->id]);
    }

    public function test_can_bulk_store_invoices()
    {
        $customer = Customer::factory()->create();
        $data = [
            [
                'customerId' => $customer->id,
                'amount' => 100,
                'status' => 'B',
                'billedDate' => '2026-02-28 10:00:00'
            ],
            [
                'customerId' => $customer->id,
                'amount' => 200,
                'status' => 'P',
                'billedDate' => '2026-02-28 11:00:00',
                'paidDate' => '2026-02-28 12:00:00'
            ]
        ];

        $response = $this->postJson('/api/v1/invoices/bulk', $data);

        $response->assertStatus(200);
        $this->assertDatabaseCount('invoices', 2);
    }
}
