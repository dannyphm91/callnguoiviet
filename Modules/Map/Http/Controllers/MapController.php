<?php

namespace Modules\Map\Http\Controllers;

use App\Models\Setting;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SetupGuide\Entities\SetupGuide;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('map::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('map::create');
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('map::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('map::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $setting = Setting::first();

        $request->validate([
            'map_type' => 'required',
            'default_lat' => 'required|numeric',
            'default_long' => 'required|numeric',
        ]);

        if ($request->from_preference) {
            if ($request->map_type == 'google-map') {
                $request->validate([
                    'google_map_key' => 'required',
                ]);
            }

            if ($request->map_type == 'google-map') {
                $setting->update([
                    'default_map' => $request->map_type,
                    'google_map_key' => $request->google_map_key,
                ]);
            } elseif ($request->map_type == 'map-box') {
                $setting->update([
                    'default_map' => $request->map_type,
                    'map_box_key' => $request->map_box_key,
                ]);
            } elseif ($request->map_type == 'leaflet') {
                $setting->update([
                    'default_map' => $request->map_type,
                ]);
            }

        } else {
            if ($request->map_type == 'google-map') {
                $request->validate(['google_map_key' => 'required']);
            } elseif ($request->map_type == 'map-box') {
                $request->validate(['map_box_key' => 'required']);
            }

            if ($request->map_type == 'google-map') {
                $setting->update(['google_map_key' => $request->google_map_key]);
            } elseif ($request->map_type == 'map-box') {
                $setting->update(['map_box_key' => $request->map_box_key]);
            }
        }

        $setting->update([
            'default_lat' => $request->default_lat,
            'default_long' => $request->default_long,
        ]);

        SetupGuide::where('task_name', 'map_setting')->update(['status' => 1]);
        flashSuccess('Map data updated !');

        return redirect()->back();
    }
}
