<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Notifications\LoginNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public $username;

    public $password;

    public $remember;

    public $captcha = null;

    public $returnUrl = null;

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function mount()
    {
        $this->username = 'customer@mail.com';
        $this->password = 'password';

        return $this->returnUrl = request()->get('returnUrl');
    }

    public function login()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required|string',
            'captcha' => config('captcha.active') ? 'required' : '',
        ]);

        if (filter_var($this->username, FILTER_VALIDATE_EMAIL)) {
            $type = 'email';
        } else {
            $type = 'username';
        }

        if (Auth::guard('user')->attempt([$type => $this->username, 'password' => $this->password], $this->remember)) {
            request()->session()->regenerate();

            storePlanInformation();
            $this->loginNotification();
            resetSessionWishlist();

            session()->flash('success', 'Logged in successfully!');

            if (request()->post_job != null) {
                return redirect()->route('frontend.post');
            } else {
                return $this->returnUrl ? redirect($this->returnUrl) : to_route('frontend.dashboard');
            }
        }

        $this->addError('username', __('the_provided_credentials_do_not_match_our_records'));
    }

    public function loginNotification()
    {
        // Send login notification
        $user = User::find(auth('user')->id());
        if (checkSetup('mail')) {
            $user->notify(new LoginNotification($user));
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
        // if (! $success) {
        //     throw ValidationException::withMessages([
        //         'captcha' => __('Google thinks, you are a bot, please refresh and try again!'),
        //     ]);
        // } else {
        //     $this->captcha = true;
        // }
    }
}
