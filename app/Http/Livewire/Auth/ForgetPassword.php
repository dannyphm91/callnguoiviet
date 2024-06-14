<?php

namespace App\Http\Livewire\Auth;

use App\Mail\SendResetPasswordMail;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class ForgetPassword extends Component
{
    use SendsPasswordResetEmails;

    public $email;

    public $captcha = null;

    public function render()
    {
        return view('livewire.auth.forget-password');
    }

    public function sendPasswordResetLink()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
            'captcha' => config('captcha.active') ? 'required' : '',
        ]);

        if (! checkMailConfig()) {
            flashError(__('mail_not_sent_for_the_reason_of_incomplete_mail_configuration'));
        }

        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $this->email,
            'token' => $token,
            'created_at' => now(),
        ]);
        $valid_mail = User::where('email', $this->email)->first();
        if ($valid_mail) {
            Mail::to($this->email)->send(new SendResetPasswordMail($token));
        } else {
            flashError(__('User not Found'));
        }
        $this->email = '';
        session()->flash('success', __('we_have_e_mailed_your_password_reset_link'));
        $this->emit('flashMessage', ['type' => 'success', 'message' => session('success')]);

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
        // if (! $success) {
        //     throw ValidationException::withMessages([
        //         'captcha' => __('Google thinks, you are a bot, please refresh and try again!'),
        //     ]);
        // } else {
        //     $this->captcha = true;
        // }
    }
}
