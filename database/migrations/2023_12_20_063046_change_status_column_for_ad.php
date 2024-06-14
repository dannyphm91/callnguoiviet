<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\Faq\Entities\Faq;
use Modules\Faq\Entities\FaqCategory;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE ads MODIFY COLUMN status ENUM('active','sold','pending','declined','draft') DEFAULT 'active' NOT NULL");
        }

        $faqCategory = FaqCategory::create([
            'name' => 'Pricing-Plan',
            'slug' => 'pricing-plan',
            'icon' => 'fab fa-bitcoin',
        ]);

        // First FAQ
        Faq::create([
            'faq_category_id' => $faqCategory->id,
            'question' => 'How can I post a new classified ad?',
            'answer' => 'To post a new classified ad, log in to your account, click the "Post Ad" button, and follow the steps to provide the ad details, including title, description, category, and upload images.',
        ]);

        // Second FAQ
        Faq::create([
            'faq_category_id' => $faqCategory->id,
            'question' => 'What payment methods are accepted?',
            'answer' => 'We accept various payment methods, including credit cards and PayPal. Choose the one that suits you best during the checkout process.',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE ads MODIFY COLUMN status ENUM('active','sold','pending','declined') DEFAULT 'active' NOT NULL");
        }
    }
};
