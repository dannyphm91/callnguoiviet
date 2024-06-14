<?php

use Modules\Faq\Entities\Faq;
use Modules\Faq\Entities\FaqCategory;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit faqcategory index page', function () {
    $this->get(route('module.faq.category.index'))
        ->assertStatus(200)
        ->assertSeeText('Faq Category List');
});

test('admin can visit faqcategory create page', function () {
    $this->get(route('module.faq.category.create'))
        ->assertStatus(200)
        ->assertSeeText('Create');
});

test('admin can record new faqcategory', function () {
    $data = [
        'name' => 'ok',
        'icon' => 'fas fa-bowling-ball',
    ];
    $this->post(route('module.faq.category.store'), $data)
        ->assertStatus(302);
    expect(FaqCategory::first()->name)->toBe('Pricing-Plan');
});

test('admin can\'t record new faqcategory for validation', function () {
    $this->post(route('module.faq.category.store'), [])
        ->assertSessionHasErrors(['icon', 'name'])
        ->assertStatus(302);
    expect(Faq::count())->toBe(2);
});

test('admin can visit faqcategory edit page', function () {

    $data = [
        'name' => 'ok',
        'icon' => 'fas fa-bowling-ball',
    ];
    $this->post(route('module.faq.category.store'), $data);
    $this->get(route('module.faq.category.edit', 1))
        ->assertStatus(200)
        ->assertSeeText('Edit');
});

test('admin can update any faqcategory', function () {
    $data = [
        'name' => 'ok',
        'icon' => 'fas fa-bowling-ball',
    ];
    $this->post(route('module.faq.category.store'), $data);

    $data = [
        'name' => 'Dhaka',
        'icon' => 'fas fa-bowling-ball',
    ];

    $this->put(route('module.faq.category.update', 1), $data)
        ->assertStatus(302);
    expect(FaqCategory::first()->name)->toBe('Dhaka');
});

test('admin can\'t update a faqcategory for validation', function () {
    $data = [
        'name' => 'ok',
        'icon' => 'fas fa-bowling-ball',
    ];
    $this->post(route('module.faq.category.store'), $data);

    $data = [];

    $this->put(route('module.faq.category.update', 1), $data)
        ->assertSessionHasErrors(['name'])
        ->assertStatus(302);
    expect(FaqCategory::first()->name)->toBe('Pricing-Plan');
});

test('admin can delete a faqcategory', function () {
    $data = [
        'name' => 'ok',
        'icon' => 'fas fa-bowling-ball',
    ];
    $this->post(route('module.faq.category.store'), $data);

    $this->delete(route('module.faq.category.destroy', 1))
        ->assertStatus(302);
    expect(FaqCategory::count())->toBe(1);
});
