<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        try {
            $reports = Report::with('reportFrom:id,name,username', 'reportTo:id,name,username')
                ->latest()
                ->paginate(10);

            return view('admin.report.list', compact('reports'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
