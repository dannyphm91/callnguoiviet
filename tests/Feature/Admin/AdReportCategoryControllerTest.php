<?php

use App\Models\AdReportCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit the ad report category index', function () {

    $response = $this->get(route('ad-report-category.index'));
    $response->assertStatus(200);
    // $response->assertViewIs('admin.ad-report.category.index');
    $response->assertSee('Listing Report Category List');
});

test('admin can store a new ad report category', function () {
    $data = ['name' => 'Test Category'];
    $response = $this->post(route('ad-report-category.store'), $data);
    $response->assertStatus(302);
    $this->assertDatabaseHas('ad_report_categories', ['name' => $data['name']]);
});

test('admin can update an ad report category', function () {

    $category = AdReportCategory::first();

    $data = ['name' => 'Updated Category'];
    $response = $this->put(route('ad-report-category.update', $category->slug), $data);
    $response->assertStatus(302);
    $this->assertDatabaseHas('ad_report_categories', ['name' => $data['name']]);
});

test('admin can delete an ad report category', function () {

    $category = AdReportCategory::first();

    $response = $this->delete(route('ad-report-category.destroy', $category->slug));
    $response->assertStatus(302);
    $this->assertDatabaseMissing('ad_report_categories', ['id' => $category->id]);
});
