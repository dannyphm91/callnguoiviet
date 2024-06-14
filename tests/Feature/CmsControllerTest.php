<?php

use App\Models\Cms;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit cms index page', function () {
    $this->get(route('settings.cms'))
        ->assertStatus(200)
        ->assertSeeText('List');
});

test('admin can update posting rules from cms', function () {
    $data = ['posting_rules_body' => '<p>Learn about our posting rules and guidelines.</p>'];

    $this->put(route('admin.posting.rules.update'), $data)
        ->assertStatus(302);
    expect(Cms::first()->posting_rules_body)->toBe('<p>Learn about our posting rules and guidelines.</p>');
});

test('admin can update about cms information', function () {
    $data = [
        'about_body' => '<p>Learn about our posting rules and guidelines.</p>',
        'about_video_url' => 'https://github.com/awal2645',
    ];

    $this->put(route('admin.about.update'), $data)
        ->assertStatus(302);
    expect(Cms::first()->about_video_url)->toBe('https://youtu.be/NR0w4K96Dl8?si=ldBnH8S-vJtOSwti');
});

test('admin can update promotions cms information', function () {
    $data = [
        'language_code' => 'en',

        'promotion_banner_title' => '<h3>Featured Listing</h3>',
        'promotion_banner_text' => '<p>Sell your items quickly at the best price by making...</p>',

        'featured_title' => '<h3>Featured Listing</h3>',
        'featured_text' => '<p>Sell your items quickly at the best price by making...</p>',

        'urgent_title' => '<h3>Featured Listing</h3>',
        'urgent_text' => '<p>Sell your items quickly at the best price by making...</p>',

        'highlight_title' => '<h3>Featured Listing</h3>',
        'highlight_text' => '<p>Sell your items quickly at the best price by making...</p>',

        'top_title' => '<h3>Featured Listing</h3>',
        'top_text' => '<p>Sell your items quickly at the best price by making...</p>',

        'bump_up_title' => '<h3>Featured Listing</h3>',
        'bump_up_text' => '<p>Sell your items quickly at the best price by making...</p>',
    ];

    $this->put(route('admin.promotions.update'), $data)
        ->assertStatus(302);
});

test('admin can update terms cms information', function () {
    $data = [
        'language_code' => 'en',
        'terms_body' => '<p>Read our terms and conditions for using our platform.</p>',
    ];

    $this->put(route('admin.terms.update'), $data)
        ->assertStatus(302);
    expect(Cms::first()->terms_body)->toBe('<p>Read our terms and conditions for using our platform.</p>');
});

test('admin can update privacy body cms information', function () {
    $data = [
        'language_code' => 'en',
        'privacy_body' => '<p>Read our privacy for using our platform.</p>',
    ];

    $this->put(route('admin.privacy.update'), $data)
        ->assertStatus(302);
    expect(Cms::first()->privacy_body)->toBe('<p>Read our privacy for using our platform.</p>');
});

test('admin can update refund body cms information', function () {
    $data = [
        'language_code' => 'en',
        'refund_body' => '<p>Read our refund for using our platform.</p>',
    ];

    $this->put(route('admin.refund.update'), $data)
        ->assertStatus(302);
    expect(Cms::first()->refund_body)->toBe('<p>Read our refund for using our platform.</p>');
});

test('admin can update get membership from cms', function () {
    $data = [
        'get_membership_image' => UploadedFile::fake()->create('upload_image.jpg', 1024),
    ];

    $this->put(route('admin.getmembership.update'), $data)
        ->assertStatus(302);

    expect(Cms::first()->get_membership_image)->not->toBe(null);
});

test('admin can update price plan from cms', function () {
    $data = [
        'pricing_plan_background' => UploadedFile::fake()->create('upload_image.jpg', 1024),
    ];

    $this->put(route('admin.pricingplan.update'), $data)
        ->assertStatus(302);

    expect(Cms::first()->pricing_plan_background)->not->toBe(null);
});

test('admin can update blog from cms', function () {
    $data = [
        'blog_background' => UploadedFile::fake()->create('upload_image.jpg', 1024),
    ];

    $this->put(route('admin.blog.update'), $data)
        ->assertStatus(302);

    expect(Cms::first()->blog_background)->not->toBe(null);
});

test('admin can update add from cms', function () {
    $data = [
        'ads_background' => UploadedFile::fake()->create('upload_image.jpg', 1024),
    ];

    $this->put(route('admin.ads.update'), $data)
        ->assertStatus(302);

    expect(Cms::first()->ads_background)->not->toBe(null);
});

test('admin can update contact information from cms', function () {
    $data = [
        'contact_number' => '+8801616657585',
        'contact_email' => 'templatecookie@gmail.com',
        'contact_address' => 'Narsingdi, Dhaka, Bangladesh',
        'contact_background' => UploadedFile::fake()->create('bg.jpg', 1024),
    ];

    $this->put(route('admin.contact.update'), $data)
        ->assertStatus(302);

    expect(Cms::first()->contact_number)->toBe('+8801616657585');
});

test('admin can update auth content from cms', function () {
    $data = [
        'manage_ads_content' => 'Manage your ads and communicate with buyers and sellers.',
        'chat_content' => 'Chat with other users and arrange deals.',
        'verified_user_content' => 'Become security',
    ];

    $this->put(route('admin.authcontent.update'), $data)
        ->assertStatus(302);

    expect(Cms::first()->verified_user_content)->toBe('Become security');
});

test('admin can update coming soon', function () {
    $data = [
        'coming_soon_title' => 'ok',
        'coming_soon_subtitle' => 'ok',
    ];
    $this->put(route('admin.comingsoon.update'), $data)
        ->assertStatus(302);

    expect(Cms::first()->coming_soon_title)->toBe('ok');
});

test('admin can update maintenance cms', function () {
    $data = [
        'maintenance_title' => 'ok',
        'maintenance_subtitle' => 'ok',
    ];
    $this->put(route('admin.maintenance.update'), $data)
        ->assertStatus(302);

    expect(Cms::first()->maintenance_subtitle)->toBe('ok');
});

test('admin can update error cms page', function () {
    $data = [
        'e404_title' => 'opu saha',
        'e404_subtitle' => "Something went wrong. It's look like the link is broken or the page is removed.",
        'e500_title' => 'Internal Server Error',
        'e500_subtitle' => "Something went wrong. It's look like the Internal Server has some errors.",
        'e503_title' => 'Service Unavailable',
        'e503_subtitle' => "Something went wrong. It's look like the Internal Server has some errors.",
        'e404_image' => UploadedFile::fake()->create('404.jpg', 1024),
        'e500_image' => UploadedFile::fake()->create('500.jpg', 1024),
        'e503_image' => UploadedFile::fake()->create('503.jpg', 1024),
    ];
    $this->put(route('admin.errorpages.update'), $data)
        ->assertStatus(302);

    expect(Cms::first()->e404_title)->toBe('opu saha');
});

test('admin can update footer from cms', function () {
    $data = [
        'footer_text' => 'Copyright 2023',
    ];

    $this->put(route('admin.footer.text.update'), $data)
        ->assertStatus(302);

    expect(Cms::first()->footer_text)->toBe('Copyright 2023');
});

test('admin can update dashboard from cms', function () {
    $data = [
        'dashboard_overview_background' => UploadedFile::fake()->create('upload.jpg', 1024),
        'dashboard_post_ads_background' => UploadedFile::fake()->create('upload.jpg', 1024),
        'dashboard_my_ads_background' => UploadedFile::fake()->create('upload.jpg', 1024),
        'dashboard_favorite_ads_background' => UploadedFile::fake()->create('upload.jpg', 1024),
        'dashboard_messenger_background' => UploadedFile::fake()->create('upload.jpg', 1024),
        'dashboard_plan_background' => UploadedFile::fake()->create('upload.jpg', 1024),
        'dashboard_account_setting_background' => UploadedFile::fake()->create('upload.jpg', 1024),
    ];
    $this->put(route('admin.dashboard.update'), $data)
        ->assertStatus(302);

    expect(Cms::first()->dashboard_messenger_background)->not->toBe(null);
});
