<?php

use Database\Seeders\Test\CategoryTestSeeder;
use Modules\category\Entities\Category;
use Modules\CustomField\Entities\CustomField;
use Modules\CustomField\Entities\CustomFieldGroup;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit custom field index page', function () {
    $this->get(route('module.custom.field.index'))
        ->assertStatus(200)
        ->assertSeeText('field');
});

test('admin can visit custom field create page', function () {
    $this->get(route('module.custom.field.create'))
        ->assertStatus(200)
        ->assertSeeText('Create');
});

test('admin can record new custom field', function () {
    $this->seed([
        CategoryTestSeeder::class,
    ]);
    CustomFieldGroup::create(['name' => 'opu', 'slug' => 'opu']);
    $data = [
        'name' => 'Bangladesh',
        'group' => '1',
        'type' => 'textarea',
        'categories' => [
            0 => '1',
        ],
        'value' => null,
        'filterable' => '1',
        'icon' => 'fas fa-bold',
    ];
    $this->post(route('module.custom.field.store'), $data)
        ->assertStatus(302);
    expect(CustomField::first()->icon)->toBe('fas fa-bold');
});

test('admin can\'t record new custom field for validation', function () {
    $this->post(route('module.custom.field.store'), [])
        ->assertSessionHasErrors(['name', 'group', 'type', 'icon'])
        ->assertStatus(302);
    expect(CustomField::count())->toBe(0);
});

test('admin can visit custom field edit page', function () {
    $this->seed([
        CategoryTestSeeder::class,
    ]);
    CustomFieldGroup::create(['name' => 'opu', 'slug' => 'opu']);
    $data = [
        'name' => 'Bangladesh',
        'group' => '1',
        'type' => 'textarea',
        'categories' => [
            0 => '1',
        ],
        'value' => null,
        'filterable' => '1',
        'icon' => 'fas fa-bold',
    ];
    $this->post(route('module.custom.field.store'), $data);
    $this->get(route('module.custom.field.edit', 1))
        ->assertStatus(200)
        ->assertSeeText('Edit');
});

test('admin can update any custom field', function () {
    Category::factory()->create();

    $this->seed([
        CategoryTestSeeder::class,
    ]);
    CustomFieldGroup::create(['name' => 'opu', 'slug' => 'opu']);
    $data = [
        'name' => 'Bangladesh',
        'group' => '1',
        'type' => 'textarea',
        'categories' => [
            0 => '1',
        ],
        'value' => null,
        'filterable' => '1',
        'icon' => 'fas fa-bold',
    ];
    $this->post(route('module.custom.field.store'), $data);

    $data = [
        'name' => 'Dhaka',
        'group' => '1',
        'type' => 'textarea',
        'categories' => [
            0 => '1',
        ],
        'value' => null,
        'filterable' => '1',
        'icon' => 'fas fa-bold',
    ];

    $this->put(route('module.custom.field.update', 1), $data)
        ->assertStatus(302);
    expect(CustomField::first()->name)->toBe('Dhaka');
});

test('admin can\'t update a custom field for validation', function () {
    Category::factory()->create();

    $this->seed([
        CategoryTestSeeder::class,
    ]);
    CustomFieldGroup::create(['name' => 'opu', 'slug' => 'opu']);
    $data = [
        'name' => 'Bangladesh',
        'group' => '1',
        'type' => 'textarea',
        'categories' => [
            0 => '1',
        ],
        'value' => null,
        'filterable' => '1',
        'icon' => 'fas fa-bold',
    ];
    $this->post(route('module.custom.field.store'), $data);

    $this->put(route('module.custom.field.update', 1), [])
        ->assertSessionHasErrors(['name', 'group', 'type', 'icon'])
        ->assertStatus(302);
    expect(CustomField::first()->name)->toBe('Bangladesh');
});

test('admin can delete a custom field', function () {
    Category::factory()->create();

    $this->seed([
        CategoryTestSeeder::class,
    ]);
    CustomFieldGroup::create(['name' => 'opu', 'slug' => 'opu']);
    $data = [
        'name' => 'Bangladesh',
        'group' => '1',
        'type' => 'textarea',
        'categories' => [
            0 => '1',
        ],
        'value' => null,
        'filterable' => '1',
        'icon' => 'fas fa-bold',
    ];
    $this->post(route('module.custom.field.store'), $data);

    $this->delete(route('module.custom.field.destroy', 1))
        ->assertStatus(302);
    expect(CustomField::count())->toBe(0);
});
