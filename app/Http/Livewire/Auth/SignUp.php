<?php

namespace App\Http\Livewire\Auth;

use App\Models\Affiliate;
use App\Models\AffiliateInvite;
use App\Models\AffiliateSetting;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class SignUp extends Component
{
    public $name;

    public $email;

    public $password;

    public $cpassword;

    public $captcha = null;

    public $code;

    public function mount()
    {
        $this->code = request()->input('aff_code', null);
    }

    public function render()
    {
        return view('livewire.auth.sign-up');
    }

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'cpassword' => 'required|same:password',
            'captcha' => config('captcha.active') ? 'required' : '',
        ], $this->customValidationMessages());

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        $affiliateCode = $this->code;

        if ($affiliateCode) {

            $invitePoints = AffiliateSetting::first()->invite_points;

            $affiliatePartner = Affiliate::where('affiliate_code', $affiliateCode)->first();
            $affiliatePartner->total_points = (int) $affiliatePartner->total_points + (int) $invitePoints;
            $affiliatePartner->save();

            AffiliateInvite::create([
                'user_id' => $affiliatePartner->user_id,
                'email' => $user->email,
                'code' => $affiliateCode,
                'points' => (int) $invitePoints,
                'status' => 1,
            ]);
        }

        //to call email verification
        event(new Registered($user));

        // Login user
        auth()->guard('user')->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ]);

        // Regenerate session and redirect to dashboard
        request()->session()->regenerate();
        session()->flash('success', 'Registration successful');

        return to_route('frontend.dashboard');
    }

    protected function customValidationMessages()
    {
        return [
            'cpassword.required' => 'The confirmation password field is required.',
            'cpassword.same' => 'The confirmation password does not match the password.',
        ];
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
