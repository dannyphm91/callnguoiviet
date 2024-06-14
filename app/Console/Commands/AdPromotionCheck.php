<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Ad\Entities\Ad;

class AdPromotionCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotion:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check ad promotion status validity and update accordingly';

    public $today;

    public $ads;

    public function __construct()
    {
        parent::__construct();

        $this->today = now()->format('Y-m-d');
        if (! app()->runningInConsole()) {
            $this->ads = Ad::all([
                'id', 'title', 'status', 'featured', 'featured_at', 'featured_till', 'urgent', 'urgent_at', 'urgent_till', 'highlight', 'highlight_at', 'highlight_till', 'top', 'top_at', 'top_till', 'bump_up', 'bump_up_at', 'bump_up_till',
            ]);
        }

    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking ad promotion status validity and update accordingly...');

        $this->info('Checking featured ads...');
        $this->checkFeaturedAds();

        $this->info('Checking urgent ads...');
        $this->checkUrgentAds();

        $this->info('Checking bump up ads...');
        $this->checkBumpUpAds();

        $this->info('Checking highlight ads...');
        $this->checkHighlightAds();

        $this->info('Checking top ads...');
        $this->checkTopAds();

        $this->info('Done!');

        info('promote command run');
    }

    /**
     * Checking featured ads.
     */
    private function checkFeaturedAds()
    {
        // Fetch all expired featured ads
        $expired_featured_ads = $this->ads
            ->where('featured_till', '!=', null)
            ->where('featured_till', '<=', $this->today)
            ->where('featured_at', '!=', null)
            ->where('featured', 1);

        $this->info($expired_featured_ads->count().' expired featured ads found.');

        // Update expired featured ads
        if ($expired_featured_ads && $expired_featured_ads->count() > 0) {
            $expired_featured_ads->each(function ($ad) {
                $ad->update([
                    'featured' => 0,
                    'featured_at' => null,
                    'featured_till' => null,
                ]);
            });
        }
    }

    /**
     * Checking urgent ads.
     */
    private function checkUrgentAds()
    {
        // Fetch all expired urgent ads
        $expired_urgent_ads = $this->ads
            ->where('urgent_till', '!=', null)
            ->where('urgent_till', '<=', $this->today)
            ->where('urgent_at', '!=', null)
            ->where('urgent', 1);

        $this->info($expired_urgent_ads->count().' expired urgent ads found.');

        // Update expired urgent ads
        if ($expired_urgent_ads && $expired_urgent_ads->count() > 0) {
            $expired_urgent_ads->each(function ($ad) {
                $ad->update([
                    'urgent' => 0,
                    'urgent_at' => null,
                    'urgent_till' => null,
                ]);
            });
        }
    }

    /**
     * Checking bump up ads.
     */
    private function checkBumpUpAds()
    {
        // Fetch all expired bump up ads
        $expired_bump_up_ads = $this->ads
            ->where('bump_up_till', '!=', null)
            ->where('bump_up_till', '<=', $this->today)
            ->where('bump_up_at', '!=', null)
            ->where('bump_up', 1);

        $this->info($expired_bump_up_ads->count().' expired bump up ads found.');

        // Update expired bump up ads
        if ($expired_bump_up_ads && $expired_bump_up_ads->count() > 0) {
            $expired_bump_up_ads->each(function ($ad) {
                $ad->update([
                    'bump_up' => 0,
                    'bump_up_at' => null,
                    'bump_up_till' => null,
                ]);
            });
        }
    }

    /**
     * Checking highlight ads.
     */
    private function checkHighlightAds()
    {
        // Fetch all expired highlight ads
        $expired_highlight_ads = $this->ads
            ->where('highlight_till', '!=', null)
            ->where('highlight_till', '<=', $this->today)
            ->where('highlight_at', '!=', null)
            ->where('highlight', 1);

        $this->info($expired_highlight_ads->count().' expired highlight ads found.');

        // Update expired highlight ads
        if ($expired_highlight_ads && $expired_highlight_ads->count() > 0) {
            $expired_highlight_ads->each(function ($ad) {
                $ad->update([
                    'highlight' => 0,
                    'highlight_at' => null,
                    'highlight_till' => null,
                ]);
            });
        }
    }

    /**
     * Checking top ads.
     */
    private function checkTopAds()
    {
        // Fetch all expired top ads
        $expired_top_ads = $this->ads
            ->where('top_till', '!=', null)
            ->where('top_till', '<=', $this->today)
            ->where('top_at', '!=', null)
            ->where('top', 1);

        $this->info($expired_top_ads->count().' expired top ads found.');

        // Update expired top ads
        if ($expired_top_ads && $expired_top_ads->count() > 0) {
            $expired_top_ads->each(function ($ad) {
                $ad->update([
                    'top' => 0,
                    'top_at' => null,
                    'top_till' => null,
                ]);
            });
        }
    }
}
