<?php

use Illuminate\Http\UploadedFile;
use Modules\category\Entities\Category;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit category index page', function () {
    $this->get(route('module.category.index'))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can visit category create page', function () {
    $this->get(route('module.category.create'))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can record new category', function () {
    $data = [
        'name' => [
            'en' => 'ok',
            'bn' => 'ok',
        ],
        'icon' => 'fas fa-bomb',
        'image' => UploadedFile::fake()->create('cat_image.jpg', 1024),
    ];
    $this->post(route('module.category.store'), $data)
        ->assertStatus(302);
    expect(category::first()->icon)->toBe('fas fa-bomb');
});

test('admin can\'t record new category for validation', function () {
    $this->post(route('module.category.store'), [])
        ->assertSessionHasErrors(['name', 'name.en', 'image', 'icon'])
        ->assertStatus(302);
    expect(category::count())->toBe(0);
});

test('admin can visit category edit page', function () {
    Category::factory()->create();

    $this->get(route('module.category.edit', 1))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can update any category', function () {
    Category::factory()->create();

    $data = [
        'name' => [
            'en' => 'ok',
            'bn' => 'ok',
        ],
        'icon' => 'fas fa-bomb',
        'image' => UploadedFile::fake()->create('cat_image.jpg', 1024),
    ];

    $this->put(route('module.category.update', 1), $data)
        ->assertStatus(302);
    expect(category::first()->icon)->toBe('fas fa-bomb');
});

test('admin can\'t update a category for validation', function () {
    Category::factory()->create();

    $this->put(route('module.category.update', 1), [])
        ->assertSessionHasErrors(['name', 'name.en', 'icon'])
        ->assertStatus(302);
});

test('admin can delete a category', function () {
    Category::factory()->create();

    $this->delete(route('module.category.destroy', 1), [])
        ->assertStatus(302);
    expect(category::count())->toBe(0);
});
