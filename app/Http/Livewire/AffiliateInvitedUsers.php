<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AffiliateInvitedUsers extends Component
{
    public $affiliateInvitedUsers;

    public $visibleRows = 5;

    public $allDataLoaded = false;

    public function render()
    {
        return view('livewire.affiliate-invited-users');
    }

    public function mount($affiliateInvitedUsers)
    {
        $this->affiliateInvitedUsers = $affiliateInvitedUsers;
    }

    public function loadMore()
    {
        if (! $this->allDataLoaded) {
            $this->visibleRows = count($this->affiliateInvitedUsers);
            $this->allDataLoaded = true;
        }
    }
}
