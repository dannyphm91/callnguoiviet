<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Ad\Entities\Ad;

class ReportAd extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reportFrom()
    {
        return $this->belongsTo(User::class, 'report_from_id');
    }

    public function reportTo()
    {
        return $this->belongsTo(Ad::class, 'report_to_id');
    }

    public function reportCategory()
    {
        // return $this->belongsTo(AdReportCategory::class, 'report_category_id');
        return $this->belongsTo(AdReportCategory::class, 'ad_report_category_id');
    }
}
