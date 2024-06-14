<?php

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit report index page', function () {
    $this->get(route('report.index'))
        ->assertStatus(200)
        ->assertSeeText('List');
});
