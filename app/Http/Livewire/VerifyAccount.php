<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\User;
use App\Models\UserDocumentVerification;
use App\Notifications\DocumentVerificationRequestNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads; // Import the WithFileUploads trait

class VerifyAccount extends Component
{
    use WithFileUploads; // Use the WithFileUploads trait

    public User $user;

    protected $rules = [
        'passport' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // 2MB Max
    ];

    public $passport;

    public function render()
    {
        return view('livewire.verify-account');
    }

    public function save()
    {

        $this->validate();

        // Upload passport file if it exists

        if ($this->passport) {
            $name = $this->passport->store();
        }

        // Create a new UserDocumentVerification record
        $document = UserDocumentVerification::create([
            'user_id' => auth()->id(),
            'password_photo_url' => $name ?? '', // Use null if $passport is not set
            'status' => 'pending',
        ]);

        if (checkMailConfig()) {
            $admins = Admin::all();
            foreach ($admins as $admin) {
                Notification::send($admin, new DocumentVerificationRequestNotification($admin, auth()->user(), $document));
            }
        }
        session()->flash('success', 'Verify successfully!');

        return to_route('frontend.dashboard');
    }
}
