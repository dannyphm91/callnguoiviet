<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdReportCategory;
use Illuminate\Http\Request;

class AdReportCategoryController extends Controller
{
    public function index()
    {
        if (! userCan('ad_report_category.view')) {
            return abort(403);
        }
        try {
            $adReportCategories = AdReportCategory::latest()->paginate(10);

            return view('admin.ad-report.category.index', compact('adReportCategories'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function create()
    {
        if (! userCan('ad_report_category.create')) {
            return abort(403);
        }
        try {
            return view('admin.ad-report.category.create');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function store(Request $request)
    {
        if (! userCan('ad_report_category.create')) {
            return abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {

            AdReportCategory::create([
                'name' => $request->name,
            ]);

            flashSuccess('Ad report category Added Successfully');

            return redirect()->route('ad-report-category.index');

            // return back();

        } catch (\Throwable $th) {
            // flashError();
            flashError('An error occured:'.$th->getMessage());

            return back();
        }
    }

    public function edit($slug)
    {
        if (! userCan('ad_report_category.edit')) {
            return abort(403);
        }
        try {

            $adReportCategories = AdReportCategory::latest()->paginate(10);
            $category = AdReportCategory::where('slug', $slug)->firstOrFail();

            return view('admin.ad-report.category.index', compact('adReportCategories', 'category'));

        } catch (\Exception $e) {
            flashError();

            return back();
        }
    }

    public function update(Request $request, $slug)
    {
        if (! userCan('ad_report_category.edit')) {
            return abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {

            $adReportCategory = AdReportCategory::where('slug', $slug)->firstOrFail();
            $adReportCategory->update([
                'name' => $request->name,
            ]);

            flashSuccess('Ad Report Category Updated Successfully');

            return redirect(route('ad-report-category.index'));
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    public function destroy($slug)
    {
        if (! userCan('ad_report_category.delete')) {
            return abort(403);
        }

        try {
            $adReportCategory = AdReportCategory::where('slug', $slug)->firstOrFail();
            $adReportCategory->delete();

            flashSuccess('Ad Report Category Deleted Successfully');

            return redirect(route('ad-report-category.index'));

        } catch (\Throwable $th) {
            flashError('Error Occurred:'.$th->getMessage());

            return back();
        }
    }
}
