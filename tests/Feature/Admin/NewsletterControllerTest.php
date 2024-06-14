<?php

use Modules\Newsletter\Entities\Email;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit users index page', function () {
    $this->get(route('module.newsletter.index'))
        ->assertStatus(200)
        ->assertSeeText('Email List');
});

test('subscribe newsletter', function () {
    $data = ['email' => 'sahaapo@gmail.com'];
    $this->post(route('newsletter.subscribe'), $data)
        ->assertStatus(200);
    expect(Email::count())->toBe(1);
});

test('admin can delete any subscription', function () {
    $data = ['email' => 'sahaapo@gmail.com'];
    $this->post(route('newsletter.subscribe'), $data);
    expect(Email::count())->toBe(1);

    $this->delete(route('module.newsletter.delete', 1))
        ->assertStatus(302);
    expect(Email::count())->toBe(0);
});
