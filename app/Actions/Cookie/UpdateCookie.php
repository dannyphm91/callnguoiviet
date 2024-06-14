<?php

namespace App\Actions\Cookie;

use Illuminate\Http\Request;

class UpdateCookie
{
    public function handle(Request $request)
    {
        $request->validate([
            'cookie_name' => 'required|max:50|string',
            'cookie_expiration' => 'required|numeric|max:365',
            'title' => 'required',
            'description' => 'required',
            'approve_button_text' => 'required|string|max:30',
            'decline_button_text' => 'required|string|max:30',
        ]);

        // updating data to database
        $cookies = cookies();
        $cookies->allow_cookies = request('allow_cookies', 0);
        $cookies->cookie_name = $request->cookie_name;
        $cookies->cookie_expiration = $request->cookie_expiration;
        $cookies->force_consent = request('force_consent', 0);
        $cookies->darkmode = request('darkmode', 0);
        $cookies->title = $request->title;
        $cookies->approve_button_text = $request->approve_button_text;
        $cookies->decline_button_text = $request->decline_button_text;
        $cookies->description = $request->description;
        $cookies->save();

    }
}
