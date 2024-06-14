<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportAd;

class AdReportController extends Controller
{
    public function index()
    {
        try {
            $reports = ReportAd::with('reportFrom:id,name,username', 'reportTo:id,title,slug')
                ->latest()
                ->paginate(10);

            return view('admin.ad-report.index', compact('reports'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function destroy(ReportAd $singleAdReport)
    {
        try {
            $singleAdReport->delete();

            flashSuccess('Ad Report Deleted Successfully');

            return redirect(route('report-ad'));
        } catch (\Throwable $th) {
            flashError('Error Occurred: '.$th->getMessage());

            return back();
        }
    }
}
