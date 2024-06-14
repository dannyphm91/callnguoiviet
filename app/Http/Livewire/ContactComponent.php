<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Notifications\ContactNotification;
use App\Rules\EmailVerificationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class ContactComponent extends Component
{
    public $name;

    public $email;

    public $subject;

    public $message;

    public $success;

    public $captcha = null;

    public function submitContact()
    {
        // $this->validate();
        $this->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'spammail', new EmailVerificationRule()],
            'subject' => 'required',
            'message' => 'required|min:10',
            'captcha' => config('captcha.active') ? 'required' : '',
        ]);

        try {
            if (checkMailConfig()) {

                $contact = [
                    'name' => $this->name,
                    'email' => $this->email,
                    'subject' => $this->subject,
                    'message' => $this->message,
                    // 'token' => Str::random(12),
                ];

                Admin::all()->each(function ($admin) use ($contact) {
                    $admin->notify(new ContactNotification($contact));
                });

                return redirect()->route('frontend.contact')->with('success', 'Your contact mail has been sent');
            }

            return redirect()->route('frontend.contact')->with('error', 'We regret to inform you that your email could not be sent due to incomplete mail configuration');
        } catch (\Throwable $th) {
            return redirect()->route('frontend.contact')->with('error', $th->getMessage());
        }
    }

    public function updatedCaptcha($token)
    {
        $response = Http::post(
            'https://www.google.com/recaptcha/api/siteverify?secret='.
            config('captcha.sitekey').
            '&response='.$token
        );

        $success = $response->json()['success'];

        if ($success) {
            $this->captcha = true;
        }
    }

    public function render()
    {
        return view('livewire.contact-component');
    }
}
