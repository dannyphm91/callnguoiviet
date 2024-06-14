<?php

namespace Database\Seeders;

use App\Models\Cms;
use Illuminate\Database\Seeder;

class PromotionsPageCmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first CMS record
        $cms = Cms::first();

        // Update the new fields
        $cms->update([
            'promotion_banner_title' => 'Add Promotions',
            'promotion_banner_text' => 'Sell your items quickly at the best price by making your listing stand out on our website! Listing Promotions is a tool that gets you more responses on your listing and helps you sell faster.',
            'promotion_banner_img' => 'frontend/images/promotions-img/promotion-banner.jpg',

            'featured_title' => 'Featured',
            'featured_text' => '<h3 class="heading-06 leading-6 mb-3">The right feature when you need to extra focus on your listing.</h3>
                                <ul class="ps-5 flex flex-col gap-3 list-disc leading-6 text-gray-600">
                                    <li>Add an extra badge to your listing as featured</li>
                                    <li>Your listing will get more attention from buyer\'s</li>
                                    <li>By adding featured badge your listings will placed a section names "Featured Listings" on home page.</li>
                                </ul>',
            'featured_img' => 'frontend/images/promotions-img/featured.jpg',

            'urgent_title' => 'Urgent',
            'urgent_text' => '<h3 class="heading-06 leading-6 mb-3">The right feature when you need to sell fast</h3>
                            <ul class="ps-5 flex flex-col gap-3 list-disc leading-6 text-gray-600">
                                <li>Flag your listing with an easy-to-spot red banner</li>
                                <li>Attract people looking to buy fast</li>
                                <li>Perfect for when you’re moving</li>
                                <li>Urgent listing get up to 2x more views and responses than regular listing</li>
                                <li>For best results, add the Urgent feature as soon as you post your listing</li>
                                <li>Buyers can filter their search results by Urgent to find a deal or the most flexible price</li>
                            </ul>',
            'urgent_img' => 'frontend/images/promotions-img/urgent.jpg',

            'highlight_title' => 'Highlight',
            'highlight_text' => '<h3 class="heading-06 leading-6 mb-3">Make every listing shine</h3>
                                <ul class="ps-5 flex flex-col gap-3 list-disc leading-6 text-gray-600">
                                    <li>A yellow background makes your listing pop for more views, responses and sales.</li>
                                    <li>Grab buyers’ attention</li>
                                    <li>Sell your items faster</li>
                                    <li>Stand out in both search and category listings</li>
                                    <li>Attract more views and responses</li>
                                    <li>For best results, add the Highlight feature as soon as you post your listing.</li>
                                </ul>',
            'highlight_img' => 'frontend/images/promotions-img/highlight.jpg',

            'top_title' => 'Top',
            'top_text' => '<h3 class="heading-06 leading-6 mb-3">Your listing deserves to be on top</h3>
                            <ul class="ps-5 flex flex-col gap-3 list-disc leading-6 text-gray-600">
                                <li>Place your listing in prime position so you can boost your sales fast</li>
                                <li>No need to use the Bump Up feature</li>
                                <li>With up to 6 times more views than regular listing, it’s the best way to sell fast.</li>
                                <li>Buyer sees it immediately in the first results of their search</li>
                                <li>Display your listing in the Top Listing section of its category</li>
                            </ul>',
            'top_img' => 'frontend/images/promotions-img/top.jpg',

            'bump_up_title' => 'Bump Up',
            'bump_up_text' => '<h3 class="heading-06 leading-6 mb-3">Bump up your ad to pole position</h3>
                                <ul class="ps-5 flex flex-col gap-3 list-disc leading-6 text-gray-600">
                                    <li>Raise your listing in the search results and be one step ahead of other sellers</li>
                                    <li>Listing are reposted automatically so you don’t have to recreate your listing from scratch – that way you save time and don’t have to worry about a thing</li>
                                    <li>Bump Up lets you keep your view counter intact to show the level of interest on your listing</li>
                                    <li>If you delete and repost your listing, you’ll lose your counter view and everyone watching your listing will lose your listing. The Bump Up feature lets you keep your counter view and seller credibility intact.</li>
                                </ul>',
            'bump_up_img' => 'frontend/images/promotions-img/bump-up.jpg',
        ]);
    }
}
