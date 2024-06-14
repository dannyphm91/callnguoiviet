<?php

// Setup before each test

use App\Models\Order;
use App\Models\Transaction;
use Modules\Plan\Database\Seeders\PlanTestDatabaseSeeder;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit order index page', function () {
    $this->get(route('order.index'))
        ->assertStatus(200)
        ->assertSeeText('Order');
});

test('admin can visit order create page', function () {
    $this->get(route('order.create'))
        ->assertStatus(200)
        ->assertSeeText('Create');
});

test('admin can record new order ', function () {

    $this->seed([
        PlanTestDatabaseSeeder::class,
    ]);

    $data = [
        'user' => '1',
        'plan' => '1',
        'currency_symbol' => '$',
        'amount' => '1',
        'usd_amount' => '2',
        'payment_provider' => 'paypal',
        'payment_status' => 'paid',
    ];

    $this->post(route('order.store'), $data)
        ->assertStatus(302);

    expect(Transaction::count())->toBe(1);
});

test('admin fails to record new order for validation', function () {
    $data = [];
    $this->post(route('order.store'), $data)
        ->assertSessionHasErrors(['plan', 'user', 'payment_provider', 'amount', 'currency_symbol', 'usd_amount', 'payment_status'])
        ->assertStatus(302);

    expect(Order::count())->toBe(0);
});

// ##miss (controller e function nai)
test('admin can delete a data', function () {
    $this->seed([
        PlanTestDatabaseSeeder::class,
    ]);

    $data = [
        'user' => '1',
        'plan' => '1',
        'currency_symbol' => '$',
        'amount' => '1',
        'usd_amount' => '2',
        'payment_provider' => 'paypal',
        'payment_status' => 'paid',
    ];

    $this->post(route('order.store'), $data);
    $this->delete(route('order.destroy', 1));

    expect(Transaction::count())->toBe(0);
});
