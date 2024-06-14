<?php

use Illuminate\Http\UploadedFile;
use Modules\Testimonial\Entities\Testimonial;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit testimonial index page', function () {
    $this->get(route('module.testimonial.index'))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can visit testimonial create page', function () {
    $this->get(route('module.testimonial.create'))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can record new testimonial', function () {
    $data = [
        'name' => 'good',
        'position' => 'test position',
        'stars' => '5',
        'code' => 'en',
        'description' => 'test description',
        'image' => UploadedFile::fake()->create('image.jpg', 1024),
    ];
    $this->post(route('module.testimonial.store'), $data)
        ->assertStatus(302);
    expect(Testimonial::first()->name)->toBe('good');
});

test('admin can\'t record new testimonial for validation', function () {
    $this->post(route('module.testimonial.store'), [])
        ->assertSessionHasErrors(['name', 'position', 'stars', 'code', 'description'])
        ->assertStatus(302);
    expect(Testimonial::count())->toBe(0);
});

test('admin can visit testimonial edit page', function () {
    $data = [
        'name' => 'good',
        'position' => 'test position',
        'stars' => '5',
        'code' => 'en',
        'description' => 'test description',
        'image' => UploadedFile::fake()->create('image.jpg', 1024),
    ];
    $this->post(route('module.testimonial.store'), $data);

    $this->get(route('module.testimonial.edit', 1))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can update any testimonial', function () {
    $data = [
        'name' => 'good',
        'position' => 'test position',
        'stars' => '5',
        'code' => 'en',
        'description' => 'test description',
        'image' => UploadedFile::fake()->create('image.jpg', 1024),
    ];
    $this->post(route('module.testimonial.store'), $data);

    $data = [
        'name' => 'Best',
        'position' => 'test position',
        'stars' => '5',
        'code' => 'en',
        'description' => 'test description',
        'image' => UploadedFile::fake()->create('image.jpg', 1024),
    ];

    $this->put(route('module.testimonial.update', 1), $data)
        ->assertStatus(302);
    expect(Testimonial::first()->name)->toBe('Best');
});

test('admin can\'t update a testimonial for validation', function () {
    $data = [
        'name' => 'Good',
        'position' => 'test position',
        'stars' => '5',
        'code' => 'en',
        'description' => 'test description',
        'image' => UploadedFile::fake()->create('image.jpg', 1024),
    ];
    $this->post(route('module.testimonial.store'), $data);

    $data = [];

    $this->put(route('module.testimonial.update', 1), $data)
        ->assertSessionHasErrors(['name', 'position', 'stars', 'code', 'description'])
        ->assertStatus(302);
    expect(Testimonial::first()->name)->toBe('Good');
});

test('admin can delete a testimonial', function () {
    $data = [
        'name' => 'good',
        'position' => 'test position',
        'stars' => '5',
        'code' => 'en',
        'description' => 'test description',
        'image' => UploadedFile::fake()->create('image.jpg', 1024),
    ];
    $this->post(route('module.testimonial.store'), $data);

    $this->delete(route('module.testimonial.destroy', 1))
        ->assertStatus(302);
    expect(Testimonial::count())->toBe(0);
});
