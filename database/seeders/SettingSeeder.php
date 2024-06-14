<?php

namespace Database\Seeders;

use App\Models\ModuleSetting;
use App\Models\Setting;
use App\Models\Timezone;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new Setting();
        $setting->sidebar_color = '#022446';
        $setting->sidebar_txt_color = '#e0e9f2';
        $setting->nav_color = '#0a243e';
        $setting->nav_txt_color = '#e0e9f2';
        $setting->main_color = '#00AAFF';
        $setting->accent_color = '#007bff';
        $setting->frontend_primary_color = '#00AAFF';
        $setting->frontend_secondary_color = '#007bff';
        $setting->logo_image = 'frontend/images/logo.svg';
        $setting->white_logo = 'frontend/images/logo-white.svg';
        $setting->favicon_image = 'frontend/images/icon/notepad.ico';
        $setting->website_loader = false;
        $setting->default_map = 'leaflet';
        $setting->google_map_key = '';
        $setting->map_box_key = '';
        $setting->default_long = 90.4112704917406;
        $setting->default_lat = 23.757853442382867;
        $setting->facebook = "https://facebook.com/zakirsoft";
        $setting->twitter = "https://twitter.com/zakirsoft";
        $setting->instagram = "https://instagram.com/zakirsoft";
        $setting->youtube = "https://www.youtube.com/channel/UCMSp_qPtYbaUMjEICDLhDCQ";
        $setting->linkdin = "https://www.linkedin.com/in/zakirsoft";
        $setting->whatsapp = "https://web.whatsapp.com/";
        $setting->save();

        // Timezone
        foreach (timezone_identifiers_list() as $zone) {
            Timezone::insert(['value' => $zone]);
        }

        // Module Setting
        ModuleSetting::create([
            'blog' => true,
            'newsletter' => true,
            'language' => true,
            'contact' => true,
            'faq' => true,
            'testimonial' => true,
            'price_plan' => true,
            'appearance' => true,
        ]);

        // Timezone
        foreach (timezone_identifiers_list() as $zone) {
            Timezone::insert(['value' => $zone]);
        }

        $setting->update([
            'push_notification_status' => false,
            'server_key' => 'your-server-key',
            'api_key' => 'your-api-key',
            'auth_domain' => 'your-auth-domain',
            'project_id' => 'your-project-id',
            'storage_bucket' => 'your-storage-bucket',
            'messaging_sender_id' => 'your-messaging-sender-id',
            'app_id' => 'your-app-id',
            'measurement_id' => 'your-measurement-id',
        ]);
    }
}
