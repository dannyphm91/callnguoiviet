<?php

namespace Database\Seeders;

use App\Models\PricePlanService;
use Illuminate\Database\Seeder;

class PricePlanServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allData = [
            [
                'title' => 'Post unlimited listings',
                'description' => 'Enjoy the freedom of showcasing your offerings without limitations. With our platform, you can effortlessly post an unlimited number of listings, ensuring that your products or services reach a wide audience. Maximize your exposure and connect with potential customers as you share your offerings seamlessly. There are no boundaries to what you can promote, so go ahead and post as many listings as you need to elevate your presence in the marketplace.',
                'path' => '../frontend/icons/paper-plus.png',
            ],
            [
                'title' => 'More affordable listing promotion.',
                'description' => 'Boost your visibility without breaking the bank! Our platform offers cost-effective listing promotion options to give your products or services the spotlight they deserve. With budget-friendly promotion packages, you can reach a larger audience without compromising your resources. Increase your ads prominence, attract more potential customers, and watch your business thrive with our more affordable listing promotion solutions. Elevate your marketing strategy without the hefty price tag',
                'path' => '../frontend/icons/arrow-up.png',
            ],
            [
                'title' => 'Invite people and make a team',
                'description' => 'Build success together by inviting others to join your team! Unlock the power of collaboration as you invite individuals to be part of your network. Create a dynamic team, share ideas, and achieve common goals. Whether you\'re working on projects, pursuing business ventures, or simply connecting with like-minded individuals, inviting people to join your team enhances synergy and opens doors to new possibilities. Empower your network, foster growth, and create a thriving community by extending invitations and building a team that\'s ready to conquer challenges and celebrate victories together!',
                'path' => '../frontend/icons/people.png',
            ],
            [
                'title' => 'Build trust with ratings & review',
                'description' => 'Build trust and credibility with our Ratings & Reviews feature! Encourage your customers to share their experiences and opinions, helping prospective clients make informed decisions. Ratings & Reviews provide valuable insights into the quality of your products or services, establishing transparency and trust in your business. Foster a community of satisfied customers and showcase the positive feedback that sets you apart. Strengthen your online presence, boost credibility, and let the authentic voices of your customers build a foundation of trust that stands out in the crowd.',
                'path' => '../frontend/icons/rating-star.png',
            ],
            [
                'title' => 'Member & verified badge',
                'description' => 'Elevate your profile with our Member & Verified Badge! As a distinguished member of our platform, you gain a mark of authenticity and trust. The Member Badge highlights your active participation, while the Verified Badge assures users that your account is legitimate and credible. Showcase your commitment to quality and reliability, instilling confidence in potential customers. Gain a competitive edge, stand out in the community, and let the Member & Verified Badge be a symbol of your credibility and trustworthiness in the world of adlisting.',
                'path' => '../frontend/icons/check.png',
            ],
            [
                'title' => 'Add more images & detailed Info',
                'description' => 'Enhance the appeal of your listings by adding more images and detailed information! Capture the attention of potential customers with a visual feast – showcase your products or services from every angle. The more images you add, the better you can present what you have to offer. Additionally, provide comprehensive details about your listings, including key features, specifications, and any other relevant information. By doing so, you not only make your listings more informative but also increase the likelihood of attracting interested buyers. Make your ad stand out from the crowd by adding more images and detailed info, ensuring that potential customers have all the information they need for a confident decision.',
                'path' => '../frontend/icons/cloud-up.png'],
            [
                'title' => 'More management & customization',
                'description' => 'Take control of your listings with more management and customization options! Our platform empowers you to tailor your listings according to your preferences. Enjoy the flexibility of customizing details, updating information, and managing your listings effortlessly. With advanced management features, you can easily track the performance of your ads, make real-time adjustments, and ensure they are always up-to-date. Maximize your advertising strategy by customizing your listings to match your unique style and needs. Experience the convenience of more management and customization tools, putting you in the driver\'s seat of your adlisting journey.',
                'path' => '../frontend/icons/gear.png',
            ],
            [
                'title' => 'Dedicated customer support',
                'description' => 'Experience unparalleled support with our dedicated customer support services. As a valued member, you gain access to a team of experts ready to assist you at every step of your adlisting journey. Our dedicated customer support is committed to providing swift and effective solutions to any queries or concerns you may have. Whether you need assistance with account management, troubleshooting, or guidance on maximizing your adlisting experience, our customer support team is here for you. Enjoy peace of mind knowing that dedicated professionals are just a message away, ensuring that you receive the personalized support you deserve as a member of our community.',
                'path' => '../frontend/icons/support.png',
            ],
            [
                'title' => 'More affordable listing promotion.',
                'description' => 'Boost your visibility without breaking the bank! Our platform offers cost-effective listing promotion options to give your products or services the spotlight they deserve. With budget-friendly promotion packages, you can reach a larger audience without compromising your resources. Increase your ads prominence, attract more potential customers, and watch your business thrive with our more affordable listing promotion solutions. Elevate your marketing strategy without the hefty price tag',
                'path' => '../frontend/icons/arrow-up.png',
            ],
            [
                'title' => 'Member & verified badge',
                'description' => 'Elevate your profile with our Member & Verified Badge! As a distinguished member of our platform, you gain a mark of authenticity and trust. The Member Badge highlights your active participation, while the Verified Badge assures users that your account is legitimate and credible. Showcase your commitment to quality and reliability, instilling confidence in potential customers. Gain a competitive edge, stand out in the community, and let the Member & Verified Badge be a symbol of your credibility and trustworthiness in the world of adlisting.',
                'path' => '../frontend/icons/check.png',
            ],
        ];

        foreach ($allData as $data) {
            PricePlanService::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'service_icon' => $data['path'],
            ]);
        }
    }
}
