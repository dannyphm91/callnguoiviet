<?php

use App\Models\User;
use Modules\Ad\Entities\Ad;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\Category;

test('add and remove ad from wishlist', function () {
    $user = User::factory()->create();
    $brand = Brand::factory()->create();
    $category = Category::factory()->create();
    $ad = Ad::factory()->create(['brand_id' => $brand->id, 'category_id' => $category->id]);

    // Add to wishlist
    $this->actingAs($user)->post(route('frontend.add.wishlist'), ['ad_id' => $ad->id, 'user_id' => $user->id])->assertStatus(302);
    $this->assertDatabaseHas('wishlists', ['ad_id' => $ad->id, 'user_id' => $user->id]);

    // Remove from wishlist
    $this->actingAs($user)->post(route('frontend.add.wishlist'), ['ad_id' => $ad->id, 'user_id' => $user->id])->assertStatus(302);
    $this->assertDatabaseMissing('wishlists', ['ad_id' => $ad->id, 'user_id' => $user->id]);
});
