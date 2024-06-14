<?php

use Illuminate\Http\UploadedFile;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit blog index page', function () {
    $this->get(route('module.post.index'))
        ->assertStatus(200)
        ->assertSeeText('Post List');
});

test('admin can visit blog create page', function () {
    PostCategory::factory()->create();
    $this->get(route('module.post.create'))
        ->assertStatus(200)
        ->assertSeeText('create');
});

test('admin can record new post', function () {
    PostCategory::factory()->create();
    $data = [
        'title' => 'test title',
        'category_id' => '1',
        'short_description' => 'Test short description',
        'description' => '<p>Test description</p>',
        'image' => UploadedFile::fake()->create('blog.jpg', 1024),
        'author_id' => 1,
    ];
    $this->post(route('module.post.store'), $data)->assertStatus(302);
    expect(Post::first()->title)->toBe('test title');
});

test('admin can\'t record new post for validation', function () {
    $this->post(route('module.post.store'), [])
        ->assertSessionHasErrors(['title', 'category_id', 'short_description', 'description', 'image'])
        ->assertStatus(302);
    expect(Post::count())->toBe(0);
});

//     PostCategory::factory()->create();
//     $this->get(route('module.post.edit',1))
//         ->assertStatus(200)
//         ->assertViewIs('post::edit')
//         ->assertViewHas('post');
// });

test('admin can update any post', function () {
    PostCategory::factory()->create();
    Post::factory()->create();

    $data = [
        'title' => 'test title',
        'category_id' => '1',
        'short_description' => 'Test short description',
        'description' => '<p>Test description</p>',
        'image' => UploadedFile::fake()->create('blog.jpg', 1024),
    ];
    $this->put(route('module.post.update', 1), $data)->assertStatus(302);
    expect(Post::first()->title)->toBe('test title');
});

test('admin can\'t update a blog for validation', function () {
    PostCategory::factory()->create();
    Post::factory()->create();

    $this->put(route('module.post.update', 1), [])
        ->assertSessionHasErrors(['title', 'category_id', 'short_description', 'description'])
        ->assertStatus(302);
});

test('admin can delete a post', function () {
    PostCategory::factory()->create();
    Post::factory()->create();

    $this->delete(route('module.post.destroy', 1))->assertStatus(302);
    expect(Post::count())->toBe(0);
});
