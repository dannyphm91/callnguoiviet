<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        if (! enableModule('appearance')) {
            abort(404);
        }
        try {
            return view('admin.themes.index');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function update(Request $request)
    {
        try {
            $theme = Theme::firstOrFail();
            $theme->update([
                'home_page' => $request->home_page,
            ]);

            return $this->index();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
