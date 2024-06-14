<?php

use Illuminate\Http\UploadedFile;
use Modules\Blog\Entities\PostCategory;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit post category index page', function () {
    $this->get(route('module.postcategory.index'))
        ->assertStatus(200);
});

test('admin can record new post category', function () {
    $data = [
        'name' => 'test title',
        'image' => UploadedFile::fake()->create('blog.jpg', 1024),
    ];
    $this->post(route('module.postcategory.store'), $data)
        ->assertStatus(302);
    expect(PostCategory::first()->name)->toBe('test title');
});

test('admin can\'t record new post category for validation', function () {
    $this->post(route('module.postcategory.store'), [])
        ->assertSessionHasErrors(['name', 'image'])
        ->assertStatus(302);
    expect(PostCategory::count())->toBe(0);
});

test('admin can update any post category', function () {
    $category = PostCategory::factory()->create();

    $data = [
        'name' => 'test title',
        'image' => UploadedFile::fake()->create('blog.jpg', 1024),
    ];
    $this->put(route('module.postcategory.update', $category->slug), $data)
        ->assertStatus(302);
    expect(PostCategory::first()->name)->toBe('test title');
});

test('admin can\'t update a post category for validation', function () {
    $category = PostCategory::factory()->create();

    $this->put(route('module.postcategory.update', $category->slug), [])
        ->assertStatus(302);
    expect(PostCategory::first()->name)->toBe($category->name);
});

test('admin can delete a post category', function () {
    PostCategory::factory()->create();

    $this->delete(route('module.postcategory.destroy', 1))
        ->assertStatus(302);
    expect(PostCategory::count())->toBe(0);
});
