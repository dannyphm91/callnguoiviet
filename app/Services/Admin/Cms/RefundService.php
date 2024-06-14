<?php

namespace App\Services\Admin\Cms;

use App\Models\CmsContent;

class RefundService
{
    public function index($request)
    {
        $refund_page = $request->lang_query;
        $refund_page_content = '';

        if ($refund_page) {
            $refund_page_content = CmsContent::where('translation_code', $refund_page)
                ->where('page_slug', 'refund_page')->first();
        }

        return $refund_page_content;
    }
}
