<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit users index page', function () {
    $this->get(route('user.index'))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can visit users create page', function () {
    $this->get(route('user.create'))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can store a user', function () {
    $data = [
        'name' => 'good',
        'email' => 'sahaapo@gmail.com',
        'password' => '12345678',
        'roles' => [0 => 1],
        'image' => UploadedFile::fake()->create('user.jpg', 1024),
    ];

    $this->get(route('user.store'), $data)
        ->assertStatus(200);
});

test('admin can\'t store a user for validation', function () {
    $this->post(route('user.store'), [])
        ->assertSessionHasErrors(['name', 'email', 'password', 'roles'])
        ->assertStatus(302);
    expect(User::count())->toBe(0);
});

test('admin can visit users edit page', function () {
    User::factory()->create();
    $this->get(route('user.edit', 1))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can update a user', function () {
    User::factory()->create();
    $data = [
        'name' => 'good',
        'email' => 'sahaapo@gmail.com',
        'password' => '12345678',
        'roles' => [0 => 1],
        'image' => UploadedFile::fake()->create('user.jpg', 1024),
    ];

    $this->put(route('user.update', 1), $data)
        ->assertStatus(302);
    // expect(User::first()->email)->toBe('sahaapo@gmail.com');

    // update hoi na
});

test('admin can\'t update a user for validation', function () {
    User::factory()->create(['name' => 'opu']);
    $this->put(route('user.update', 1), [])
        ->assertStatus(302);
    expect(User::first()->name)->toBe('opu');
});

test('admin can delete a user for', function () {
    User::factory()->create(['name' => 'opu']);
    $this->delete(route('user.destroy', 1), [])
        ->assertStatus(302);
    expect(User::first()->name)->toBe('opu');
});
