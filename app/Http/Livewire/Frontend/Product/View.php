<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Wishlists;
use Illuminate\Support\Facades\Auth;

class View extends Component
{   

    public $category, $product, $productColorSelectedQuantity, $quantityCount = 1, $productColorId;

    public function addToWishList($productId){
        
        if(Auth::check())
        {
            
            if (Wishlists::where('user_id',auth()->user()->id)->where('product_id',$productId)->exists())
            {
                session()->flash('message','Already added to Wishlists');
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Already added to Wishlists',
                    'type' => 'warning',
                    'status' => 409
                ]);
                return false;
            }
            else
            {

                 Wishlists::create([
                    'user_id'=>auth()->user()->id,
                    'product_id' => $productId
                ]);
                $this->emit('wishListAddedUpdated');
                session()->flash('message','Wishlist Added Successfully');
                
                $this->dispatchBrowserEvent('message', [
                'text' => 'Wishlist Added Successfully',
                'type' => 'success',
                'status' => 200
            ]);
            }
        }
        else
        {
            session()->flash('message','Please Log in to Continue');
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please Log in to Continue',
                'type' => 'info',
                'status' => 401
            ]);
            return false;
        }

    }

    public function colorSelected($productColorId){

        $this->productColorId = $productColorId;
        $productColor = $this->product->productColors()->where('id',$productColorId)->first();
        $this->productColorSelectedQuantity = $productColor->quantity;

        if($this->productColorSelectedQuantity == 0){
            $this->productColorSelectedQuantity = 'outOfStock';
        }
    }

    public function incrementQuantity(){
        if ($this->quantityCount < 10) {
            $this->quantityCount++;
        } else {
            return false;
        }
    }
    public function decrementQuantity(){

        if ($this->quantityCount > 1) {
            $this->quantityCount--;
        } else {
            return false;
        }
        
    }

    public function addToCart(int $productId)
    {
        if (Auth::check()) {
            if ($this->product->where('id', $productId)->where('status', '0')->exists()) {
    
                // Taga tignin kung maraming color ba yung product
                if ($this->product->productColors()->count() > 1) {
    
                    // titignan kung may pinili ka na eh ikaw hindi pinili HAHAHAH iyaq
                    if ($this->productColorSelectedQuantity != NULL) {
                        
                        if (Cart::where('user_id',auth()->user()->id)
                                    ->where('product_id', $productId)
                                    ->where('product_color_id', $this->productColorId)
                                    ->exists())
                        {
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Product Already Added',
                                'type' => 'info',
                                'status' => 200
                            ]);
                        }
                        else
                        {

                        
                            // kukunin yung pinili mo
                            $productColor = $this->product->productColors()->where('id', $this->productColorId)->first();
                            
                            // tignan kung may stock pa ba
                            if ($productColor->quantity > 0) {
                                // Add the product to the cart
                                    if ($productColor->quantity > $this->quantityCount) {
            
                                    Cart::create([
                                        'user_id' => auth()->user()->id,
                                        'product_id' => $productId,
                                        'product_color_id' => $this->productColorId,
                                        'quantity' => $this->quantityCount
                                    ]);
                                        $this->emit('CartAddedUpdated');
                                        $this->dispatchBrowserEvent('message', [
                                            'text' => 'Product Added to Cart',
                                            'type' => 'success',
                                            'status' => 200
                                        ]);
                                    } else {
                
                                        $this->dispatchBrowserEvent('message', [
                                            'text' => 'Only' . $productColor->quantity . ' Quantity Available',
                                            'type' => 'error',
                                            'status' => 404
                                        ]);
                                    }

                            } else {
                                $this->dispatchBrowserEvent('message', [
                                    'text' => 'Out of Stock',
                                    'type' => 'error',
                                    'status' => 404
                                ]);
                            }
                        }
                    } else {
    
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Select your product color',
                            'type' => 'info',
                            'status' => 404
                        ]);
    
                    }
    
                } else {
                    // Product has only one color
                    
                    if (Cart::where('user_id',auth()->user()->id)->where('product_id', $productId)->exists()) {
                        
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Product Already Added',
                            'type' => 'info',
                            'status' => 200
                        ]);

                    } else {
                        # code...
                    
                    

                    // Check if the product has enough quantity
                        if ($this->product->quantity > 0) {
        
                            // Check if the user selected quantity is within the product's available quantity
                            if ($this->product->quantity > $this->quantityCount) {
        
                                // Add the product to the cart
                                Cart::create([
                                        'user_id' => auth()->user()->id,
                                        'product_id' => $productId,
                                        'quantity' => $this->quantityCount
                                    ]);
                                        $this->emit('CartAddedUpdated');
                                        $this->dispatchBrowserEvent('message', [
                                            'text' => 'Product Added to Cart',
                                            'type' => 'success',
                                            'status' => 200
                                        ]);
        
                            } else {
        
                                $this->dispatchBrowserEvent('message', [
                                    'text' => 'Only' . $this->product->quantity . ' Quantity Available',
                                    'type' => 'error',
                                    'status' => 404
                                ]);
                            }
        
                        } else {
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Out of Stock',
                                'type' => 'error',
                                'status' => 404
                            ]);
                        }
                    }
                }
            } else {
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Product does not Exist',
                    'type' => 'error',
                    'status' => 404
                ]);
            }
        } else {
    
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please Log in to Add to Cart',
                'type' => 'info',
                'status' => 401
            ]);
    
        }
    }


    public function mount($category, $product){
        
        $this->category = $category;
        $this->product = $product;
    
    }

    public function render()
    {
        return view('livewire.frontend.product.view',[
            'category'  => $this->category,
            'product'  => $this->product
        ]);
    }
}
