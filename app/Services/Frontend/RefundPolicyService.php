<?php

namespace App\Services\Frontend;

use App\Models\Cms;
use App\Models\CmsContent;

class RefundPolicyService
{
    public function refund(): array
    {
        $lang = currentLangCode() ?? 'en';
        $data['cms'] = Cms::select(['refund_body', 'refund_background'])->first();
        $data['refund_content'] = '';

        if ($lang != 'en') {
            $get_content = CmsContent::where('page_slug', 'refund_page')->where('translation_code', $lang)->first();
            if ($get_content) {
                $data['refund_content'] = $get_content->text;
            } else {
                $get_content = Cms::select(['refund_body'])->first();
                $data['refund_content'] = $get_content->terms_body;
            }
        } else {
            $get_content = Cms::select(['refund_body'])->first();
            $data['refund_content'] = $get_content->terms_body;
        }

        return $data;
    }
}
