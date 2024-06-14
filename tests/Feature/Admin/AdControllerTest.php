<?php

use App\Models\User;
use Database\Seeders\Test\CategoryTestSeeder;
use Illuminate\Http\UploadedFile;
use Modules\ad\Entities\Ad;
use Modules\Brand\Entities\Brand;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit ad index page', function () {
    $this->get(route('module.ad.index'))
        ->assertStatus(200);
    // ->assertViewIs('ad::index')
    // ->assertViewHas(['ads']);
});

test('admin can visit ad create page', function () {
    $this->seed([
        CategoryTestSeeder::class,
    ]);
    User::factory()->create();
    Brand::factory()->create();
    $this->get(route('module.ad.create'))
        ->assertStatus(200);
});

test('admin can record new ad', function () {
    $this->seed([
        CategoryTestSeeder::class,
    ]);
    User::factory()->create();
    Brand::factory()->create();
    $data = [
        'title' => 'Test add',
        'brand_id' => '1',
        'user_id' => '1',
        'price' => '1',
        'category_id' => '1',
        'subcategory_id' => '1',
        'show_phone' => '1',
        'phone' => '88001616657585',
        'whatsapp' => '01616657585',
        'featured' => '1',
        'features' => [
            0 => 'test feature',
        ],
        'description' => '<p>test description</p>',
        'thumbnail' => UploadedFile::fake()->create('thumbnail.jpg', 1024),
    ];
    $this->post(route('module.ad.store'), $data)
        ->assertStatus(302);
});

test('admin can\'t record new ad for validation', function () {
    $this->post(route('module.ad.store'), [])
        ->assertSessionHasErrors(['title', 'price', 'category_id', 'brand_id', 'description', 'thumbnail', 'user_id'])
        ->assertStatus(302);
    expect(Ad::count())->toBe(0);
});

test('admin can visit ad edit page', function () {

    $this->seed([
        CategoryTestSeeder::class,
    ]);
    User::factory()->create();
    Brand::factory()->create();
    Ad::factory()->create();
    $this->get(route('module.ad.edit', 1))
        ->assertStatus(200);
});

test('admin can update any ad', function () {
    $this->seed([
        CategoryTestSeeder::class,
    ]);
    User::factory()->create();
    Brand::factory()->create();
    Ad::factory()->create();

    $data = [
        'title' => 'New Title',
        'user_id' => 1,
        'category_id' => 1,
        'subcategory_id' => 1,
        'brand_id' => 1,
        'price' => 1,
        'description' => 'update',
    ];
    $this->put(route('module.ad.update', 1), $data)
        ->assertStatus(302);
    expect(ad::first()->user_id)->toBe(1);
});

test('admin can\'t update a ad for validation', function () {
    $this->seed([
        CategoryTestSeeder::class,
    ]);
    User::factory()->create();
    Brand::factory()->create();
    Ad::factory()->create();

    $this->post(route('module.ad.store', 1), [])
        ->assertStatus(302);
    expect(ad::first()->user_id)->toBe(1);
});

test('admin can delete a ad', function () {
    $this->seed([
        CategoryTestSeeder::class,
    ]);
    User::factory()->create();
    Brand::factory()->create();
    Ad::factory()->create();

    $this->delete(route('module.ad.destroy', 1))
        ->assertStatus(302);
    expect(ad::count())->toBe(0);
});
