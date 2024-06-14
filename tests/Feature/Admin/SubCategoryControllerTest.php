<?php

use Database\Seeders\Test\CategoryTestSeeder;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategory;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit subcategory index page', function () {
    $this->get(route('module.subcategory.index'))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can visit subcategory create page', function () {
    Category::factory()->create();
    $this->get(route('module.subcategory.create'))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can record new subcategory', function () {
    Category::factory()->create();

    $data = [
        'category_id' => '1',
        'name' => [
            'en' => 'wq',
            'bn' => 're',
        ],
    ];
    $this->post(route('module.subcategory.store'), $data)
        ->assertStatus(302);
    expect(SubCategory::first()->category_id)->toBe(1);
});

test('admin can\'t record new subcategory for validation', function () {
    $this->post(route('module.subcategory.store'), [])
        ->assertSessionHasErrors([
            'category_id' => 'The category field is required.',
        ])->assertStatus(302);
    expect(Subcategory::count())->toBe(0);
});

test('admin can visit subcategory edit page', function () {
    $this->seed([CategoryTestSeeder::class]);
    $this->get(route('module.subcategory.edit', 1))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can update any subcategory', function () {
    $this->seed([CategoryTestSeeder::class]);

    $data = [
        'category_id' => '1',
        'name' => [
            'en' => 'wq',
            'bn' => 're',
        ],
    ];

    $this->put(route('module.subcategory.update', 1), $data)
        ->assertStatus(302);
    expect(subcategory::first()->category_id)->toBe(1);
});

test('admin can\'t update a subcategory for validation', function () {
    $this->seed([CategoryTestSeeder::class]);

    $this->put(route('module.subcategory.update', 1), [])
        ->assertSessionHasErrors([
            'category_id' => 'The category field is required.',
        ])->assertStatus(302);
});

test('admin can delete a subcategory', function () {
    $this->seed([CategoryTestSeeder::class]);

    expect(subcategory::count())->toBe(3);

    $this->delete(route('module.subcategory.destroy', 1), [])
        ->assertStatus(302);
    expect(subcategory::count())->toBe(2);

});
