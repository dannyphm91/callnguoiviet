<?php

namespace App\Services\Frontend;

use App\Models\Cms;
use App\Models\CmsContent;

class PromotionsService
{
    public function promotions(): array
    {
        $lang = currentLangCode() ?? 'en';
        $data['cms'] = Cms::select([
            'promotion_banner_title', 'promotion_banner_text', 'promotion_banner_img',
            'featured_title', 'featured_text', 'featured_img',
            'urgent_title', 'urgent_text', 'urgent_img',
            'highlight_title', 'highlight_text', 'highlight_img',
            'top_title', 'top_text', 'top_img',
            'bump_up_title', 'bump_up_text', 'bump_up_img',
        ])->first();

        $data['promotionTitle'] = '';
        $data['promotionText'] = '';

        $data['featuredTitle'] = '';
        $data['featuredText'] = '';

        $data['urgentTitle'] = '';
        $data['urgentText'] = '';

        $data['highlightTitle'] = '';
        $data['highlightText'] = '';

        $data['topText'] = '';
        $data['topText'] = '';

        $data['bumpUpText'] = '';
        $data['bumpUpText'] = '';

        if ($lang != 'en') {
            $get_content = CmsContent::where('page_slug', 'promotions_page')->where('translation_code', $lang)->first();
            if ($get_content) {
                $data['promotionTitle'] = $get_content->title;
                $data['promotionText'] = $get_content->text;

                $data['featuredTitle'] = $get_content->title_featured;
                $data['featuredText'] = $get_content->text_featured;

                $data['urgentTitle'] = $get_content->title_urgent;
                $data['urgentText'] = $get_content->text_urgent;

                $data['highlightTitle'] = $get_content->title_highlight;
                $data['highlightText'] = $get_content->text_highlight;

                $data['topTitle'] = $get_content->title_top;
                $data['topText'] = $get_content->text_top;

                $data['bumpUpTitle'] = $get_content->title_bump_up;
                $data['bumpUpText'] = $get_content->text_bump_up;
            } else {
                $get_content = Cms::select([
                    'promotion_banner_title', 'promotion_banner_text',
                    'featured_title', 'featured_text',
                    'urgent_title', 'urgent_text',
                    'highlight_title', 'highlight_text',
                    'top_title', 'top_text',
                    'bump_up_title', 'bump_up_text',
                ])->first();
                $data['promotionTitle'] = $get_content->promotion_banner_title;
                $data['promotionText'] = $get_content->promotion_banner_text;

                $data['featuredTitle'] = $get_content->featured_title;
                $data['featuredText'] = $get_content->featured_text;

                $data['urgentTitle'] = $get_content->urgent_title;
                $data['urgentText'] = $get_content->urgent_text;

                $data['highlightTitle'] = $get_content->highlight_title;
                $data['highlightText'] = $get_content->highlight_text;

                $data['topTitle'] = $get_content->top_title;
                $data['topText'] = $get_content->top_text;

                $data['bumpUpTitle'] = $get_content->bump_up_title;
                $data['bumpUpText'] = $get_content->bump_up_text;
            }
        } else {
            $get_content = Cms::select([
                'promotion_banner_title', 'promotion_banner_text',
                'featured_title', 'featured_text',
                'urgent_title', 'urgent_text',
                'highlight_title', 'highlight_text',
                'top_title', 'top_text',
                'bump_up_title', 'bump_up_text',
            ])->first();
            $data['promotionTitle'] = $get_content->promotion_banner_title;
            $data['promotionText'] = $get_content->promotion_banner_text;

            $data['featuredTitle'] = $get_content->featured_title;
            $data['featuredText'] = $get_content->featured_text;

            $data['urgentTitle'] = $get_content->urgent_title;
            $data['urgentText'] = $get_content->urgent_text;

            $data['highlightTitle'] = $get_content->highlight_title;
            $data['highlightText'] = $get_content->highlight_text;

            $data['topTitle'] = $get_content->top_title;
            $data['topText'] = $get_content->top_text;

            $data['bumpUpTitle'] = $get_content->bump_up_title;
            $data['bumpUpText'] = $get_content->bump_up_text;
        }

        return $data;
    }
}
