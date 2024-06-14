<?php

namespace Database\Seeders;

use App\Models\Cms;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cms::create([

            //About
            'about_body' => "<p class=\"mb-4\">Welcome to Jobpilot! We are a dedicated team of professionals who are passionate about quality. Our mission is to serve you best quality products.</p>

            <p class=\"mb-4\">Founded in 2022, we have been on a journey to provide the best software to our customers. With years of experience and a commitment to excellence, we have built a reputation for quality.</p>

            <p class=\"mb-4\">At Jobpilot, we take pride in our [mention any unique aspects of your business], striving to exceed our customers' expectations. We believe in quality, and this is reflected in everything we do.</p>

            <p class=\"mb-4\">Our dedicated team of experts is here to increase and ensure your experience with us is exceptional. We are always looking for new ways to elaborate the quality of product.</p>

            <p class=\"mb-4\">Thank you for choosing Jobpilot. We look forward to serving you and being a part of your modern life.</p>",

            'about_video_thumb' => 'frontend/default_images/about_video_thumb.jpeg',

            // Terms & Condition
            'terms_body' => "<h3 class=\"mb-2 fw-bolder\"><strong>Please read these terms and conditions carefully before using Jobpilot.</strong></h3><p class=\"mb-4\">Your access to and use of the Website is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users, and others who access or use the Website. By accessing or using the Website, you agree to be bound by these Terms. If you disagree with any part of the terms, then you may not access the Website.</p><h3 class=\"mb-2 fw-bolder\"><strong>1. Use of the Website</strong></h3><ul class=\"mb-4\"><li>By using the Website, you represent and warrant that you are of legal age and have the legal capacity to enter into these Terms.</li><li>You agree not to use the Website for any illegal or unauthorized purpose and to comply with all applicable laws and regulations.</li></ul><h3 class=\"mb-2 fw-bolder\"><strong>2. Intellectual Property</strong></h3><ul class=\"mb-4\"><li>The Website and its original content, features, and functionality are owned by Jobpilot and are protected by international copyright, trademark, patent, trade secret, and other intellectual property or proprietary rights laws.</li><li>You may not use any content from the Website without our express written consent.</li></ul><h3 class=\"mb-2 fw-bolder\"><strong>3. User Accounts</strong></h3><ul class=\"mb-4\"><li>When you create an account with us, you are responsible for maintaining the confidentiality of your account and password, and for restricting access to your computer or device.</li><li>You agree to accept responsibility for all activities that occur under your account or password.</li></ul><h3 class=\"mb-2 fw-bolder\"><strong>4. Privacy Policy</strong></h3><ul class=\"mb-4\"><li>Our Privacy Policy governs your use of the Website. Please review our Privacy Policy to understand how we collect, use, and disclose information.</li></ul><h3 class=\"mb-2 fw-bolder\"><strong>5. Links to Other Websites</strong></h3><ul class=\"mb-4\"><li>Our Website may contain links to third-party websites. These links are provided solely for your convenience. We have no control over the content of these websites and are not responsible for their content.</li></ul><h3 class=\"mb-2 fw-bolder\"><strong>6. Disclaimer</strong></h3><ul class=\"mb-4\"><li>The information provided on the Website is for general informational purposes only and should not be taken as professional advice.</li></ul><h3 class=\"mb-2 fw-bolder\"><strong>7. Limitation of Liability</strong></h3><ul class=\"mb-4\"><li>In no event shall Jobpilot or its affiliates be liable for any direct, indirect, special, incidental, or consequential damages arising out of the use or inability to use the Website.</li></ul><h3 class=\"mb-2 fw-bolder\"><strong>8. Changes to Terms</strong></h3><ul class=\"mb-4\"><li>We reserve the right to change or modify these Terms at any time without notice. It is your responsibility to review these Terms periodically.</li></ul><h3 class=\"mb-2 fw-bolder\"><strong>9. Governing Law</strong></h3><ul class=\"mb-4\"><li>These Terms are governed by and construed in accordance with the laws of our Advocate without regard to its conflict of law principles.</li></ul><h3 class=\"mb-2 fw-bolder\"><strong>10. Contact Information</strong></h3><p class=\"mb-4\">If you have any questions about these Terms and Conditions, please contact us.</p><p class=\"mb-4\">By using our Website, you agree to these Terms and Conditions. If you do not agree with any part of these Terms, please do not use the Website.</p><p class=\"mb-4\">Please remember that this is a basic template, and you should consult with a legal professional to adapt it to your specific needs and legal requirements. Additionally, the 'Last Updated' date should be kept current to reflect any updates to the terms and conditions.</p>",

            //Privacy
            'privacy_body' => "<p class=\"mb-4\">At Jobpilot, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your data when you use our services and visit our website.</p>

            <h3 class=\"mb-2 fw-bolder\"><strong>1. Information We Collect</strong></h3>
            <p class=\"mb-4\">We may collect various types of information, including but not limited to:</p>
            <ul class=\"mb-4\">
                <li>Your personal information, such as your name, email address, and contact details, which you provide when signing up for our services or filling out forms on our website.</li>
                <li>Information about your usage of our services, including log data, device information, and analytics about how you interact with our website and applications.</li>
            </ul>

            <h3 class=\"mb-2 fw-bolder\"><strong>2. How We Use Your Information</strong></h3>
            <p class=\"mb-4\">We use the collected information for various purposes, including:</p>
            <ul class=\"mb-4\">
                <li>Providing and maintaining our services to you.</li>
                <li>Improving and customizing our services and your user experience.</li>
                <li>Sending you updates, promotions, and important information about our services.</li>
            </ul>

            <h3 class=\"mb-2 fw-bolder\"><strong>3. Information Sharing</strong></h3>
            <p class=\"mb-4\">We may share your information with third parties under certain circumstances:</p>
            <ul class=\"mb-4\">
                <li>With your consent or at your request.</li>
                <li>With trusted service providers and business partners to assist us in delivering and improving our services.</li>
                <li>If required by law or to protect our rights, privacy, safety, or property, and that of the public.</li>
            </ul>
            <p class=\"mb-4\">You have the right to access, correct, update, or delete your personal information. If you wish to do so or have any concerns about your data, please contact us.</p><h3 class=\"mb-2 fw-bolder\">6. Changes to Privacy Policy</h3>
            <p class=\"mb-4\">We may update our Privacy Policy from time to time. Any changes will be posted on this page with a revised 'Last Updated' date.</p>

            <h3 class=\"mb-2 fw-bolder\"><strong>4. Contact Us</strong></h3>
            <p class=\"mb-4\">If you have questions or concerns about this Privacy Policy or our data practices, please contact us.</p>",

            //Refund
            'refund_body' => '<p class="mb-4">At Jobpilot, we are committed to ensuring your satisfaction with our products and services. This Refund Policy explains our refund process and your rights as a customer. Please read this policy carefully.</p>

            <h3 class="mb-2 fw-bolder"><strong>1. Eligibility for a Refund:</strong></h3>
            <p class="mb-4">We may collect various types of information, including but not limited to:</p>
            <ul class="mb-4">
                <li>Your personal information, such as your name, email address, and contact details, which you provide when signing up for our services or filling out forms on our website.</li>
                <li>Information about your usage of our services, including log data, device information, and analytics about how you interact with our website and applications.</li>
            </ul>

            <h3 class="mb-2 fw-bolder"><strong>2. How to Request a Refund:</strong></h3>
            <p class="mb-4">To request a refund, please follow these steps:</p>
            <ul class="mb-4">
                <li>Contact our customer support team by +1-202-555-0125 or email us at templatecookie@gmail.com and explain the reason for your refund request.</li>
                <li>Include any supporting documentation, such as order numbers, receipts, or proof of payment, to help expedite the process.</li>
            </ul>

            <h3 class="mb-2 fw-bolder"><strong>3. Refund Processing:</strong></h3>
            <p class="mb-4">We will review your refund request and may require additional information. Once your request is approved, we will initiate the refund process. Please note the following:</p>
            <ul class="mb-4">
                <li>Refunds will be processed using the original method of payment.</li>
                <li>Processing times may vary depending on your payment provider, but we will make every effort to process your refund as quickly as possible.</li>
            </ul>

            <h3 class="mb-2 fw-bolder"><strong>4. Contact Us:</strong></h3>
            <p class="mb-4">If you have any questions or concerns about our refund policy or need assistance with a refund request, please contact our customer support team at Mohammadpur, Dhaka, Bangladesh. We are here to assist you.</p>',

            //Faq
            'faq_content' => 'Find answers to common questions in our FAQ section.',

            // Login or Register
            'manage_ads_content' => 'Manage your ads and communicate with buyers and sellers.',
            'chat_content' => 'Chat with other users and arrange deals.',
            'verified_user_content' => 'Become a verified user for added trust and security.',
            'posting_rules_body' => '<p>Learn about our posting rules and guidelines.</p>',

            //Contact
            'contact_number' => '+1-202-555-0125',
            'contact_email' => 'templatecookie@gmail.com',
            'contact_address' => 'Mohammadpur, Dhaka, Bangladesh',

            'e404_title' => 'Opps! Page Not Found!',
            'e404_subtitle' => 'Something went wrong. It\'s look like the link is broken or the page is removed.',
            'e404_image' => 'frontend/images/bg/error.png',
            'e500_title' => 'Internal Server Error',
            'e500_subtitle' => 'Something went wrong. It\'s look like the Internal Server has some errors.',
            'e500_image' => 'frontend/default_images/error-banner.png',
            'e503_title' => 'Service Unavailable',
            'e503_subtitle' => 'Something went wrong. It\'s look like the Internal Server has some errors.',
            'e503_image' => 'frontend/default_images/error-banner.png',

        ]);
    }
}
