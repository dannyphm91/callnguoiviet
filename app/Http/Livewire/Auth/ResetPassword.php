<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ResetPassword extends Component
{
    public $password;

    public $cpassword;

    public $token;

    public function render()
    {
        return view('livewire.auth.reset-password');
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => 'required|min:8',
            'cpassword' => 'required|same:password',
        ], $this->customValidationMessages());

        $updatePassword = DB::table('password_resets')
            ->where([
                'token' => $this->token,
            ])
            ->first();
        if (! $updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        User::where('email', $updatePassword->email)
            ->update(['password' => bcrypt($this->password)]);

        DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();
        session()->flash('success', 'Your password has been changed!');

        return redirect('/login');
    }

    protected function customValidationMessages()
    {
        return [
            'cpassword.required' => 'The confirmation password field is required.',
            'cpassword.same' => 'The confirmation password does not match the password.',
        ];
    }
}
