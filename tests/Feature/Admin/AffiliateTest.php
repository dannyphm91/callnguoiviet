<?php

use App\Models\Affiliate;
use App\Models\AffiliatePointHistory;
use App\Models\AffiliateSetting;
use App\Models\RedeemPoint;
use App\Models\User;
use Database\Seeders\AffiliatePointSeeder;
use Database\Seeders\AffiliatesTableSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

uses(RefreshDatabase::class);

test('admin can get partners', function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
    $this->withoutExceptionHandling();
    $this->get(route('affiliate.partners'))->assertStatus(200);
});

test('admin can get balance requests', function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
    $this->withoutExceptionHandling();
    $this->get(route('affiliate.balance.request'))->assertStatus(200);
});

test('admin can confirm balance request', function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
    $this->seed([AffiliatesTableSeeder::class]);
    $this->seed([AffiliatePointSeeder::class]);
    $requestBalance = AffiliatePointHistory::first();
    $partnerWallet = Affiliate::first();
    $response = $this->get(route('affiliate.balance.request.confirm', ['id' => $requestBalance->id]));
    $this->assertDatabaseHas('affiliates', [
        'user_id' => $partnerWallet->user_id,
        'balance' => $partnerWallet->balance + $requestBalance->pricing,
    ]);
    $this->assertDatabaseHas('affiliate_point_histories', [
        'id' => $requestBalance->id,
        'status' => 1,
    ]);
    $response->assertStatus(302);
});

test('admin can access affiliate setting index', function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
    //  $affiliateSettings = AffiliateSetting::first();
    $response = $this->get(route('affiliate-settings.index'));
    $response->assertOk();
    //  $response->assertViewIs('admin.affiliate-settings.index',compact('affiliateSettings'));
    //  $response->assertViewHas('affiliateSettings', $affiliateSettings);

});

test('admin update affiliate setting', function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
    $affiliateSetting = AffiliateSetting::first();

    $request = new Request([
        'invite_points' => 10,
        'point_convert_permission' => 1,
    ]);
    $response = $this->put('admin/affiliate-settings/'.$affiliateSetting->id, $request->all());
    $response->assertStatus(302);
    $response->assertRedirect(route('affiliate-settings.index'));

    $this->assertDatabaseHas('affiliate_settings', [
        'invite_points' => 10,
        'point_convert_permission' => 1,
    ]);
});

test('user can generate affiliate code and redirect to wallet', function () {
    $this->seed(UserSeeder::class);
    $user = User::first();

    Affiliate::create(['user_id' => $user->id]);

    $this->actingAs($user)->get(route('frontend.become.affiliate'))->assertStatus(302)->assertRedirect(route('frontend.wallet'));

    $wallet = Affiliate::where('user_id', $user->id)->first();

    $this->assertNotNull($wallet);
    $this->assertNotNull($wallet->affiliate_code);
    $this->assertGreaterThanOrEqual(100000, $wallet->affiliate_code);
    $this->assertLessThanOrEqual(999999, $wallet->affiliate_code);
});

test('user can return wallet view with correct data when affiliate code is not null', function () {
    $this->seed(UserSeeder::class);
    $user = User::first();

    Affiliate::create(['user_id' => $user->id, 'affiliate_code' => rand(100000, 999999)]);

    $response = $this->actingAs($user)->get(route('frontend.wallet'));
    $response->assertStatus(200);
});

test('it should deduct points and add balance when point conversion is allowed', function () {
    $this->seed(UserSeeder::class);
    $user = User::first();

    $affiliate = Affiliate::create(['user_id' => $user->id, 'total_points' => 500]);

    $affiliateSettings = AffiliateSetting::create(['point_convert_permission' => 1]);

    $redeemPoints = RedeemPoint::create(['points' => 100, 'redeem_balance' => 50]);

    $response = $this->actingAs($user)->post(route('frontend.wallet.redeemPoints', ['id' => $redeemPoints->id]));

    $response->assertStatus(302);

    $affiliate->refresh();

    $this->assertEquals(400, $affiliate->total_points);
    $this->assertEquals(50, $affiliate->balance);
});

test('it should return 200 status for sign up url with affiliate code', function () {
    $this->seed(UserSeeder::class);
    $user = User::first();

    $affiliate = Affiliate::create(['user_id' => $user->id, 'affiliate_code' => rand(100000, 999999)]);

    $response = $this->get(url('/sign-up/account?aff_code='.$affiliate->affiliate_code));

    $response->assertStatus(200);
});
