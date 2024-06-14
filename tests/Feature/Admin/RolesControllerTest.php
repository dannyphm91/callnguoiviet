<?php

use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit role index page', function () {
    $this->get(route('role.index'))
        ->assertStatus(200)
        ->assertSeeText('Role');
});

test('admin can visit role create page', function () {
    $this->get(route('role.create'))
        ->assertStatus(200)
        ->assertSeeText('Role');
});

test('admin can record new role', function () {
    $data = [
        'name' => 'Role',
    ];
    $this->post(route('role.store'), $data)
        ->assertStatus(302);
    expect(Role::find(2)->name)->toBe('Role');
});

test('admin can\'t record new role for validation', function () {
    $this->post(route('role.store'), [])
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);
    expect(Role::count())->toBe(1);
});

test('admin can visit role edit page', function () {
    Role::create(['name' => 'Customer']);

    $this->get(route('role.edit', 1))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can update any role', function () {
    $role = Role::create(['name' => 'Customer']);

    $data = [
        'name' => 'Windows',
    ];
    $this->put(route('role.update', $role), $data)
        ->assertStatus(302);
});

test('admin can\'t update a role for validation', function () {
    Role::create(['name' => 'Customer']);

    $this->put(route('role.update', 2), [])
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);
    expect(Role::find(2)->name)->toBe('Customer');
});

test('admin can delete a role', function () {
    Role::create(['name' => 'HR']);

    $this->delete(route('role.destroy', 2))
        ->assertStatus(302);
    expect(Role::count())->toBe(1);
});
