<?php

namespace App\Services\Admin\Settings;

class RecaptchaUpdateService
{
    public function update($request)
    {
        $request->validate([
            'nocaptcha_key' => 'required',
            'nocaptcha_secret' => 'required',
        ]);

        checkSetConfig('captcha.sitekey', $request->nocaptcha_key);
        checkSetConfig('captcha.secret', $request->nocaptcha_secret);
        checkSetConfig('captcha.active', $request->status ? true : false);
    }
}
