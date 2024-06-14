<?php

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit social login index page', function () {
    $this->get(route('settings.social.login'))
        ->assertStatus(200);
});
