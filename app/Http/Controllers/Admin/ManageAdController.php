<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class ManageAdController extends Controller
{
    public function __construct()
    {
        $this->middleware('access_limitation')->only(['update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(! userCan('advertisement.index'), 403);

        try {
            $ads = Advertisement::all();

            return view('admin.settings.pages.advertisement', compact('ads'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $ad_codes = $request->ad_code;

            foreach ($request->page_slug as $key => $value) {
                $get_ad = Advertisement::where('page_slug', $value)->first();

                if ($get_ad) {
                    $get_ad->update([
                        'ad_code' => $ad_codes[$key],
                    ]);
                }
            }

            flashSuccess('Advertisement code updated !');

            return redirect()->back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function update_ad_status(Request $request)
    {
        try {
            $advertisement = Advertisement::find($request['id']);
            $advertisement->status = $request['status'];
            $advertisement->save();
            forgetCache('advertisements');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
