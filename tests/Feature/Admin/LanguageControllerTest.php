<?php

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit language index page', function () {
    $this->get(route('language.index'))
        ->assertStatus(200)
        ->assertSeeText('Language');
});

test('admin can visit language create page', function () {
    $this->get(route('language.create'))
        ->assertStatus(200)
        ->assertSeeText('Create');
});
