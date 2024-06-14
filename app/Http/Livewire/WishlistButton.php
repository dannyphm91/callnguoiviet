<?php

namespace App\Http\Livewire;

use App\Notifications\AdWishlistNotification;
use Livewire\Component;
use Modules\Ad\Entities\Ad;
use Modules\Wishlist\Entities\Wishlist;

class WishlistButton extends Component
{
    public Ad $ad;

    public function mount(Ad $ad)
    {
        $this->ad = $ad;
    }

    public function addToWishlist()
    {
        try {
            $user = auth('user')->user();
            $data = Wishlist::where('ad_id', $this->ad->id)
                ->whereUserId($user->id)
                ->first();

            if ($data) {
                $data->delete();

                if (checkSetup('mail')) {
                    $user->notify(new AdWishlistNotification($user, 'remove', $this->ad->slug));
                }

                $this->dispatchBrowserEvent('alert', [
                    'type' => 'success',
                    'message' => 'Listing removed from wishlist',
                ]);
            } else {
                Wishlist::create([
                    'ad_id' => $this->ad->id,
                    'user_id' => $user->id,
                ]);

                if (checkSetup('mail')) {
                    $user->notify(new AdWishlistNotification($user, 'add', $this->ad->slug));
                }
                $this->dispatchBrowserEvent('alert',
                    ['type' => 'success',  'message' => 'Listing added to wishlist!']);
            }

            // Assuming resetSessionWishlist() is a helper function you have defined
            resetSessionWishlist();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => 'Listing error occurred: '.$e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        $isWishlisted = Wishlist::where('ad_id', $this->ad->id)
            ->whereUserId(auth('user')->id())
            ->exists();

        return view('livewire.wishlist-button', [
            'isWishlisted' => $isWishlisted,
        ]);
    }
}
