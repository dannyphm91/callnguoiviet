<?php

namespace App\Services\Admin\Settings;

class BroadcastUpdateService
{
    public function update($request)
    {
        $request->validate([
            'pusher_app_id' => 'required',
            'pusher_app_key' => 'required',
            'pusher_app_secret' => 'required',
            'pusher_port' => 'required',
            'pusher_schema' => 'required',
            'pusher_app_cluster' => 'required',
        ]);

        envReplace('PUSHER_APP_ID', $request->pusher_app_id);
        envReplace('PUSHER_APP_KEY', $request->pusher_app_key);
        envReplace('PUSHER_APP_SECRET', $request->pusher_app_secret);
        envReplace('PUSHER_HOST', $request->pusher_host);
        envReplace('PUSHER_PORT', $request->pusher_port);
        envReplace('PUSHER_SCHEME', $request->pusher_schema);
        envReplace('PUSHER_APP_CLUSTER', $request->pusher_app_cluster);
    }
}
