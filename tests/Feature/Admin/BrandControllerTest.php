<?php

use Modules\Brand\Entities\Brand;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit brand index page', function () {
    $this->get(route('module.brand.index'))
        ->assertStatus(200)
        ->assertSeeText('Brand List');
});

test('admin can record new brand', function () {
    $data = [
        'name' => 'Brand',
    ];
    $this->post(route('module.brand.store'), $data)
        ->assertStatus(302);
    expect(Brand::first()->name)->toBe('Brand');
});

test('admin can\'t record new brand for validation', function () {
    $this->post(route('module.brand.store'), [])
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);
    expect(Brand::count())->toBe(0);
});

test('admin can visit brand edit page', function () {
    Brand::create(['name' => 'Saha', 'slug' => 'saha']);

    $this->get(route('module.brand.edit', 1))
        ->assertStatus(200)
        ->assertSeeText('Edit');
});

test('admin can update any brand', function () {
    Brand::create(['name' => 'Saha', 'slug' => 'saha']);

    $data = [
        'name' => 'Windows',
    ];
    $this->put(route('module.brand.update', 1), $data)
        ->assertStatus(302);
    expect(Brand::first()->name)->toBe('Windows');
});

test('admin can\'t update a brand for validation', function () {
    Brand::create(['name' => 'Saha', 'slug' => 'saha']);

    $this->put(route('module.brand.update', 1), [])
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);
    expect(Brand::first()->name)->toBe('Saha');
});

test('admin can delete a brand', function () {
    Brand::create(['name' => 'Saha']);

    $this->delete(route('module.brand.destroy', 1))
        ->assertStatus(302);
    expect(Brand::count())->toBe(0);
});
