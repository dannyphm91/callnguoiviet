<?php

namespace App\Services\Frontend;

use App\Models\Admin;
use App\Models\UserDocumentVerification;
use App\Notifications\DocumentVerificationRequestNotification;
use Illuminate\Support\Facades\Notification;

class CustomerAccountVerifyService
{
    public function verify(): array
    {
        $data['user'] = auth('user')->user();
        $data['document_verified'] = $data['user']->document_verified;

        return $data;
    }

    public function verifyAccountSubmit(object $request)
    {
        // passport
        if ($request->hasFile('passport')) {
            $passport = uploadFileToStorage($request->passport, 'user-document');
        }

        $document = UserDocumentVerification::create([
            'user_id' => auth()->id(),
            'password_photo_url' => $passport,
            'status' => 'pending',
        ]);

        // mail to admin
        if (checkMailConfig()) {
            $admins = Admin::all();
            foreach ($admins as $admin) {
                Notification::send($admin, new DocumentVerificationRequestNotification($admin, auth()->user(), $document));
            }
        }
    }
}
