<?php

use App\Models\AdReportCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can report an ad', function () {
    // Create a user
    $user = User::factory()->create();

    // Get the first AdReportCategory
    $category = AdReportCategory::first();

    // Authenticate the user
    $this->actingAs($user, 'user');

    // Define the request data
    $data = [
        'report_type' => $category->id,
        'report_description' => 'This is a test report',
        'ad_id' => 1, // replace with an actual ad id
    ];

    // Send the post request
    $response = $this->post(route('frontend.adReport'), $data);

    // Assert it was successful
    $response->assertStatus(200);

    // Assert the report was created in the database
    $this->assertDatabaseHas('report_ads', [
        'report_from_id' => $user->id,
        'report_to_id' => $data['ad_id'],
        'ad_report_category_id' => $data['report_type'],
        'report_description' => $data['report_description'],
    ]);
});
