<?php

namespace App\Services\Admin\Cms;

use App\Models\CmsContent;

class PromotionsService
{
    public function index($request)
    {
        $promotion_page = $request->lang_query;
        $promotion_page_content = '';

        if ($promotion_page) {
            $promotion_page_content = CmsContent::where('translation_code', $promotion_page)
                ->where('page_slug', 'promotions_page')->first();
        }

        return $promotion_page_content;
    }
}
