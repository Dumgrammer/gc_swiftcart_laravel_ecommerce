<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Wishlists;
use Livewire\Component;

class WishlistShow extends Component
{   

    public function removeWishListItem(int $wishlistId)
    {

        Wishlists::where('user_id', auth()->user()->id)->where('id',$wishlistId)->delete();
        $this->emit('wishListAddedUpdated');
        $this->dispatchBrowserEvent('message',[
            'text' => 'Wishlist Item Removed Successfully',
            'type' => 'success',
            'status' => 200
        ]);
    }

    public function render()
    {
        $wishlist = Wishlists::where('user_id', auth()->user()->id)->get();
        return view('livewire.frontend.wishlist-show',[
            'wishlist' => $wishlist
        ]);
    }
}
