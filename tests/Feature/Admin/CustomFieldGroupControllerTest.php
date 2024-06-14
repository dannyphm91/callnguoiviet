<?php

use Modules\CustomField\Entities\CustomField;
use Modules\CustomField\Entities\CustomFieldGroup;
use Modules\Language\Entities\Language;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit custom field group index page', function () {
    $this->get(route('module.custom.field.group.index'))
        ->assertStatus(200)
        ->assertSeeText('Custom Field Group List');
});

test('admin can record new custom group field', function () {

    $data = ['name' => 'opu', 'slug' => 'opu'];

    $this->post(route('module.custom.field.group.store'), $data)
        ->assertStatus(302);
    expect(CustomFieldGroup::first()->name)->toBe('opu');
});

test('admin can\'t record new custom group field for validation', function () {
    $this->post(route('module.custom.field.group.store'), [])
        ->assertSessionHasErrors('name')
        ->assertStatus(302);
    expect(CustomFieldGroup::count())->toBe(0);
});

test('admin can update any custom field group', function () {
    Language::create([
        'name' => 'English',
        'code' => 'en',
        'icon' => 'flag-icon-gb',
        'direction' => 'ltr',
    ]);
    $data = ['name' => 'opu', 'slug' => 'opu'];
    $this->post(route('module.custom.field.group.store'), $data);

    $cfg = CustomFieldGroup::first();
    $data = ['name' => 'Bangladesh'];

    $this->put(route('module.custom.field.group.update', $cfg), $data)
        ->assertStatus(302);
    expect(CustomFieldGroup::first()->name)->toBe('Bangladesh');
});

test('admin can delete a category', function () {
    $data = ['name' => 'opu', 'slug' => 'opu'];
    $this->post(route('module.custom.field.group.store'), $data);

    $this->delete(route('module.custom.field.group.destroy', 1))
        ->assertStatus(302);
    expect(CustomField::count())->toBe(0);
});
