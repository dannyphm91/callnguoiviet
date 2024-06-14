<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Modules\Language\Entities\Language;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit customer index page', function () {
    $this->get(route('module.customer.index'))
        ->assertStatus(200)
        ->assertSeeText('Customer List');
});

test('admin can visit customer create page', function () {
    $this->get(route('module.customer.create'))
        ->assertStatus(200)
        ->assertSeeText('Create');
});

test('admin can record new customer', function () {
    $data = [
        'name' => 'opu',
        'username' => 'opusaha',
        'email' => 'admin@mail.com',
        'password' => 'password',
        'image' => UploadedFile::fake()->create('customer_image', 1024),
    ];
    $this->post(route('module.customer.store'), $data)
        ->assertStatus(302);
    expect(User::first()->name)->toBe('opu');
});

test('admin can\'t record new customer for validation', function () {
    $data = [];
    $this->post(route('module.customer.store'), $data)
        ->assertSessionHasErrors(['name', 'username', 'email', 'password'])
        ->assertStatus(302);
    expect(User::count())->toBe(0);
});

test('admin can view customer details page', function () {
    $user = User::factory()->create();

    Language::create([
        'name' => 'English',
        'code' => 'en',
        'icon' => 'flag-icon-gb',
        'direction' => 'ltr',
    ]);

    $this->get(route('module.customer.show', $user))
        ->assertStatus(200)
        ->assertSeeText('Pricing Plan');
});

test('admin can edit a customer', function () {
    $user = User::factory()->create();

    $this->get(route('module.customer.edit', $user))
        ->assertStatus(200)
        ->assertSeeText('Edit');
});

test('admin can update any customer', function () {
    $user = User::factory()->create();

    $data = [
        'name' => 'opu',
        'username' => 'opusaha',
        'email' => 'admin@mail.com',
        'password' => 'password',
        'image' => UploadedFile::fake()->create('customer_image', 1024),
    ];
    $this->put(route('module.customer.update', $user), $data)
        ->assertStatus(302);
    expect(User::first()->name)->toBe('opu');
});

test('admin can\'t update a customer for validation', function () {
    $user = User::factory()->create();
    $data = [];
    $this->put(route('module.customer.update', $user), $data)
        ->assertSessionHasErrors(['name', 'username', 'email'])
        ->assertStatus(302);
    expect(User::count())->toBe(1);
});

test('admin can delete a customer', function () {
    $user = User::factory()->create();
    $this->delete(route('module.customer.destroy', $user))
        ->assertStatus(302);
    expect(User::count())->toBe(0);
});
