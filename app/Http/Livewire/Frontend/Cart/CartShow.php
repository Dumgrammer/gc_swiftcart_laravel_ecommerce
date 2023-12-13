<?php

namespace App\Http\Livewire\Frontend\Cart;

use App\Models\Cart;
use Livewire\Component;

class CartShow extends Component
{   

    public $cart, $totalPrice = 0;

    public function incrementQuantity(int $cartId){
        $cartData = Cart::where('id',$cartId)->where('user_id', auth()->user()->id)->first();
        if($cartData){
    
            if($cartData->productColor){
                $productColor = $cartData->productColor;
                if($productColor->quantity > $cartData->quantity){
    
                    $cartData->increment('quantity');
                    $this->dispatchBrowserEvent('message',[
                        'text' => 'Quantity Updated',
                        'type' => 'success',
                        'status' => 200
                    ]);
                }else{
                    $this->dispatchBrowserEvent('message',[
                        'text' => 'Only '.$productColor->quantity.' Quantity Available',
                        'type' => 'success',
                        'status' => 200
                    ]);
                }
            }else{
                if ($cartData->product->quantity > $cartData->quantity) {
                    $cartData->increment('quantity');
                    $this->dispatchBrowserEvent('message',[
                        'text' => 'Quantity Updated',
                        'type' => 'success',
                        'status' => 200
                    ]);
                }else{
                    $this->dispatchBrowserEvent('message',[
                        'text' => 'Only '.$cartData->product->quantity.' Quantity Available',
                        'type' => 'success',
                        'status' => 200
                    ]);
                }
            }
    
        }else{
            $this->dispatchBrowserEvent('message',[
                'text' => 'Something went wrong',
                'type' => 'error',
                'status' => 404
            ]);
        }
    }
    
    public function decrementQuantity(int $cartId){
        $cartData = Cart::where('id',$cartId)->where('user_id', auth()->user()->id)->first();
        if($cartData){
    
            if($cartData->quantity > 1){
                if($cartData->productColor){
                    $productColor = $cartData->productColor;
                    if($productColor->quantity > $cartData->quantity){
    
                        $cartData->decrement('quantity');
                        $this->dispatchBrowserEvent('message',[
                            'text' => 'Quantity Updated',
                            'type' => 'success',
                            'status' => 200
                        ]);
                    }else{
                        $cartData->decrement('quantity');
                    }
                }else{
                    if ($cartData->product->quantity > $cartData->quantity) {
                        $cartData->decrement('quantity');
                        $this->dispatchBrowserEvent('message',[
                            'text' => 'Quantity Updated',
                            'type' => 'success',
                            'status' => 200
                        ]);
                    }else{
                        $this->dispatchBrowserEvent('message',[
                            'text' => 'Only '.$cartData->product->quantity.' Quantity Available',
                            'type' => 'success',
                            'status' => 200
                        ]);
                    }
                }
            } else {
                $this->dispatchBrowserEvent('message',[
                    'text' => 'Quantity cannot be lower than 1',
                    'type' => 'error',
                    'status' => 400
                ]);
            }
    
        }else{
            $this->dispatchBrowserEvent('message',[
                'text' => 'Something went wrong',
                'type' => 'error',
                'status' => 404
            ]);
        }
    }

    public function removeCartItem(int $cartId){
        $cartRemoveData = Cart::where('user_id',auth()->user()->id)->where('id',$cartId)->first();
        if($cartRemoveData){
            $cartRemoveData->delete();

            $this->emit('CartAddedUpdated');
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Cart Item Removed Successfully',
                    'type' => 'success',
                    'status' => 500
                ]);
        
        }else{
            $this->dispatchBrowserEvent('message', [
                'text' => 'Something went wrong',
                'type' => 'error',
                'status' => 200
            ]);
        }
    }   

    public function render()
    {   
        $this->cart = Cart::where('user_id',auth()->user()->id)->get();
        return view('livewire.frontend.cart.cart-show',[
            'cart' => $this->cart
            //etong 'cart' na yan yan yung tatawagin natin sa cart-show.blade.php okay then yung value 
            //niyan is manggagaling sa Cart model where yung user id is authenticated sa user table then i ge get method
        ]);
    }
}
