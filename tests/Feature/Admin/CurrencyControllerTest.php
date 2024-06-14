<?php

use Modules\Currency\Entities\Currency;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
    $this->seed([LocationDatabaseSeeder::class]);
});

test('admin can visit currency index page', function () {
    $this->get(route('module.currency.index'))
        ->assertStatus(200)
        ->assertSeeText('currency');
});

test('admin can visit currency create page', function () {
    $this->get(route('module.currency.create'))
        ->assertStatus(200)
        ->assertSeeText('Create');
});

test('admin can store new currency', function () {
    $data = [
        'name' => 'Bangladeshi Taka',
        'code' => 'BDT',
        'symbol' => '৳',
        'rate' => 110,
        'symbol_position' => 'rtl',
    ];

    $this->post(route('module.currency.store'), $data)->assertStatus(302);
    expect(Currency::first()->name)->toBe('Bangladeshi Taka');
});

test('admin fails to store new currency for validation', function () {
    $this->post(route('module.currency.store'), [])
        ->assertStatus(302)
        ->assertSessionHasErrors(['name', 'code', 'symbol']);
    expect(Currency::count())->toBe(0);
});

test('admin can visit currency edit page', function () {
    $data = [
        'name' => 'Bangladeshi Taka',
        'code' => 'BDT',
        'symbol' => '৳',
        'rate' => 110,
        'symbol_position' => 'rtl',
    ];

    $this->post(route('module.currency.store'), $data);
    $this->get(route('module.currency.edit', 1))
        ->assertStatus(200)
        ->assertSeeText('Edit');
});

test('admin can update new currency', function () {
    $data = [
        'name' => 'Bangladeshi Taka',
        'code' => 'BDT',
        'symbol' => '৳',
        'rate' => 110,
        'symbol_position' => 'rtl',
    ];

    $this->post(route('module.currency.store'), $data);

    $data = [
        'name' => 'Indian Rupee',
        'code' => 'BDT',
        'symbol' => '৳',
        'rate' => 110,
        'symbol_position' => 'rtl',
    ];

    $this->put(route('module.currency.update', 1), $data)
        ->assertStatus(302);

    expect(Currency::first()->name)->toBe('Indian Rupee');
});

test('admin can\'t update new currency for', function () {
    $data = [
        'name' => 'Bangladeshi Taka',
        'code' => 'BDT',
        'symbol' => '৳',
        'rate' => 110,
        'symbol_position' => 'rtl',
    ];

    $this->post(route('module.currency.store'), $data);

    $this->put(route('module.currency.update', 1), [])
        ->assertStatus(302)
        ->assertSessionHasErrors(['name', 'code', 'symbol']);

    expect(Currency::first()->name)->toBe('Bangladeshi Taka');
});

test('admin can delete any currency', function () {
    $data = [
        'name' => 'Bangladeshi Taka',
        'code' => 'BDT',
        'symbol' => '৳',
    ];

    $this->post(route('module.currency.delete', 1), $data);

    expect(Currency::count())->toBe(0);
});
