<?php

namespace Tests\Admin\Feature;

use App\Models\AdReportCategory;
use App\Models\ReportAd;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit the ad report index', function () {
    // Create a user and a report
    $user = User::factory()->create();

    // Send the get request
    $response = $this->get(route('report-ad'));

    // Assert it was successful
    $response->assertStatus(200);

    // Assert the correct view was returned
    // $response->assertViewIs('admin.ad-report.index');
    $response->assertSee('Listing Report List');
});

test('admin can delete an ad report', function () {
    // Create related models
    $reportFrom = User::factory()->create();
    $reportTo = User::factory()->create();

    // Create a report category
    $reportCategory = AdReportCategory::create([
        'name' => 'Test Category',
    ]);

    // Create a report
    $report = ReportAd::create([
        'report_from_id' => $reportFrom->id,
        'report_to_id' => $reportTo->id,
        'ad_report_category_id' => $reportCategory->id,
        'report_description' => 'Test report description',
    ]);

    // Send the delete request
    $response = $this->delete(route('report-ad.destroy', $report->id));

    // Assert it was successful
    $response->assertStatus(302);

    // Assert the report was deleted from the database
    $this->assertDatabaseMissing('report_ads', ['id' => $report->id]);
});
