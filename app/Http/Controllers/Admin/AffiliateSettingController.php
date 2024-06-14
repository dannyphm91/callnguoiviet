<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateSetting;
use Illuminate\Http\Request;

class AffiliateSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $affiliateSettings = AffiliateSetting::firstorcreate();

            return view('admin.affiliate-settings.index', compact('affiliateSettings'));

        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'invite_points' => 'numeric',
            'point_convert_permission' => 'numeric',
        ]);

        try {
            $affiliateSetting = AffiliateSetting::first();

            if (! $affiliateSetting) {
                flashError('Affiliate Setting not found.');

                return back();
            }

            $affiliateSetting->update([
                'invite_points' => $request->invite_points ?? 0,
                'point_convert_permission' => $request->point_convert_permission,
            ]);

            flashSuccess('Settings Updated Successfully');

            return redirect()->route('affiliate-settings.index');

        } catch (\Throwable $th) {
            flashError('An error occurred: '.$th->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
