<?php

namespace Modules\Faq\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Faq\Entities\Faq;
use Modules\Faq\Entities\FaqCategory;
use Modules\Language\Entities\Language;

class FaqDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $faqCategories = FaqCategory::all();

        // Define the FAQ data
        $faqData = [
            [
                'question' => 'How can I post a new classified ad?',
                'answer' => 'To post a new classified ad, log in to your account, click the "Post Ad" button, and follow the steps to provide the ad details, including title, description, category, and upload images.',
            ],
            [
                'question' => 'Is there a fee for posting classified ads?',
                'answer' => 'Posting basic classified ads is free of charge. However, we offer premium ad packages with enhanced features for a small fee.',
            ],
            [
                'question' => 'How can I contact the seller?',
                'answer' => 'You can contact the seller by clicking the "Contact Seller" button on the ad listing. You can then send a message to the seller for inquiries or negotiations.',
            ],
        ];

        // Loop through each FAQ category
        foreach ($faqCategories as $category) {
            // Loop through each language
            foreach (Language::all() as $language) {
                // Create a FAQ record for each language
                foreach ($faqData as $faq) {
                    Faq::create([
                        'faq_category_id' => $category->id,
                        'question' => $faq['question'],
                        'answer' => $faq['answer'],
                        'code' => $language->code,
                    ]);
                }
            }
        }
    }
}
