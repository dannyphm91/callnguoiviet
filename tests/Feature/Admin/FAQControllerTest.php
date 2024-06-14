<?php

use Modules\Faq\Database\Seeders\FaqCategorySeeder;
use Modules\Faq\Entities\Faq;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit faq index page', function () {
    $this->get(route('module.faq.index'))
        ->assertStatus(200)
        ->assertSeeText('Create');
});

test('admin can visit faq create page', function () {
    $this->get(route('module.faq.create'))
        ->assertStatus(200)
        ->assertSeeText('Create');
});

test('admin can record new faq', function () {
    $this->seed(FaqCategorySeeder::class);
    $data = [
        'code' => 'en',
        'faq_category_id' => '1',
        'question' => 'How can I post a new classified ad?',
        'answer' => 'ok',
    ];
    $this->post(route('module.faq.store'), $data)
        ->assertStatus(302);
    expect(Faq::first()->question)->toBe('How can I post a new classified ad?');
});

test('admin can\'t record new faq for validation', function () {
    $this->post(route('module.faq.store'), [])
        ->assertSessionHasErrors(['code', 'faq_category_id', 'question', 'answer'])
        ->assertStatus(302);
    expect(Faq::count())->toBe(2);
});

test('admin can visit faq edit page', function () {
    $this->seed([
        FaqCategorySeeder::class,
    ]);

    $data = [
        'code' => 'en',
        'faq_category_id' => '1',
        'question' => 'is it ok?',
        'answer' => 'ok',
    ];
    $this->post(route('module.faq.store'), $data);
    $this->get(route('module.faq.edit', 1))
        ->assertStatus(200)
        ->assertSeeText('Edit');
});

test('admin can update any faq', function () {
    $this->seed([
        FaqCategorySeeder::class,
    ]);

    $data = [
        'code' => 'en',
        'faq_category_id' => '1',
        'question' => 'is it ok?',
        'answer' => 'ok',
    ];
    $this->post(route('module.faq.store'), $data);

    $data = [
        'code' => 'en',
        'faq_category_id' => '1',
        'question' => 'is it ok?',
        'answer' => 'yes, it is ok',
    ];

    $this->put(route('module.faq.update', 1), $data)
        ->assertStatus(302);
    expect(Faq::first()->answer)->toBe('yes, it is ok');
});

test('admin can\'t update a faq for validation', function () {
    $this->seed([
        FaqCategorySeeder::class,
    ]);

    $data = [
        'code' => 'en',
        'faq_category_id' => '1',
        'question' => 'is it ok?',
        'answer' => 'ok',
    ];
    $this->post(route('module.faq.store'), $data);

    $data = [];

    $this->put(route('module.faq.update', 1), $data)
        ->assertSessionHasErrors(['code', 'faq_category_id', 'question', 'answer'])
        ->assertStatus(302);
    // expect(Faq::first()->answer)->toBe('ok');
});

test('admin can delete a faq', function () {
    $this->seed([
        FaqCategorySeeder::class,
    ]);

    $data = [
        'code' => 'en',
        'faq_category_id' => '2',
        'question' => 'is it ok?',
        'answer' => 'ok',
    ];
    $this->post(route('module.faq.store'), $data);

    $this->delete(route('module.faq.destroy', 2))
        ->assertStatus(302);
    expect(Faq::count())->toBe(2);
});
