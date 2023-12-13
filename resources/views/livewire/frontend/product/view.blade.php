
<div class="py-3 py-md-5">
    <div class="container">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
        @endif
        <div class="row">
            <!-- Product Image Column -->
            <div class="col-md-5 mt-3">
                <div class="bg-white border" wire:ignore>
                    @if ($product->productImages)
                        <!--{{--<img src="{{ asset($product->productImages[0]->image) }}" class="w-100" alt="Product Image">--}}-->
                        <div class="exzoom" id="exzoom">
                            <!-- Images -->
                            <div class="exzoom_img_box">
                              <ul class='exzoom_img_ul'>
                                @foreach ($product->productImages as $itemImage)                                    
                                    <li><img src="{{ asset($itemImage->image) }}"/></li>
                                @endforeach
                              </ul>
                            </div>

                            <div class="exzoom_nav"></div>

                            <p class="exzoom_btn">
                                <a href="javascript:void(0);" class="exzoom_prev_btn"> < </a>
                                <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                            </p>
                          </div>
                    @else
                        No Added Images
                    @endif
                </div>
            </div>

            <!-- Product Details Column -->
            <div class="col-md-7 mt-3">
                <div class="product-view">
                    <h4 class="product-name">{{$product->name}}</h4>
                    
                    <hr>
                    <p class="product-path">
                        Home / {{$product->category->name}} / {{$product->name}}
                    </p>

                    <!-- Prices -->
                    <div>
                        <span class="selling-price">{{$product->selling_price}}</span>
                        <span class="original-price">{{$product->original_price}}</span>
                    </div>

                    <!-- Colors and Stock Status -->
                    <div>
                        @if ($product->productColors->count() > 0)
                            @if ($product->productColors)
                                @foreach ($product->productColors as $colorItem)
                                    {{--<input type="radio" name="colorSelection" value="{{$colorItem->id}}"/>{{$colorItem->color->name}}--}}
                                    <label class="colorSelectionLabel" style="background-color: {{$colorItem->color->code}}"
                                        wire:click="colorSelected({{$colorItem->id}})"
                                        >
                                        {{$colorItem->color->name}}
                                    </label>
                                @endforeach
                            @endif
                            
                            @if ($this->productColorSelectedQuantity == 'outOfStock')
                            <div>
                            <label class="btn btn-sm py-1 mt-2 text-white btn-warning">Out Stock</label>
                            </div>
                            @elseif ($this->productColorSelectedQuantity > 0)
                            <div> 
                            <label class="btn btn-sm py-1 mt-2 text-white bg-success">In Stock</label>
                            </div>
                            @endif

                        @else
                            @if ($product->quantity)
                            <label class="btn btn-sm py-1 mt-2 text-white bg-success">In Stock</label>
                            @else
                            <label class="btn btn-sm py-1 mt-2 text-white bg-danger">Out Stock</label>
                            @endif
                        @endif
                            
                    </div>

                    <!-- Quantity Input -->
                    <div class="mt-2">
                        <div class="input-group">
                            <span class="btn btn1" wire:click="decrementQuantity"><i class="fa fa-minus"></i></span>
                            <input type="text" value="{{$this->quantityCount}}" wire:model="quantityCount" readonly class="input-quantity" />
                            <span class="btn btn1" wire:click="incrementQuantity"><i class="fa fa-plus"></i></span>
                        </div>
                    </div>

                    <!-- Add to Cart and Wishlist Buttons -->
                    <div class="mt-2" wire:ignore>
                        <button type="button" wire:click="addToCart({{$product->id}})"class="btn btn1">
                            <i class="fa fa-shopping-cart"></i> Add To Cart
                        </button>
                        <button type="button" wire:click="addToWishList({{$product->id}})" class="btn btn1">
                            <span wire:loading.remove wire:target="addToWishList">
                                <i class="fa fa-heart"></i> Add To Wishlist
                            </span>
                            <span wire:loading wire:target="addToWishList">
                                Adding...
                            </span>
                        </button>
                    </div>

                    <!-- Short Description -->
                    <div class="mt-3">
                        <h5 class="mb-0">Short Description</h5>
                        <p>{!! $product->small_description !!}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-header bg-white">
                        <h4>Description</h4>
                    </div>
                    <div class="card-body">
                        <p>{!! $product->description !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-3 py-md-5 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
                <h3>Related Products</h3>
                <div class="underline"></div>
            </div>
                    @forelse ($category->relatedProducts as $relatedProductItem)
                    <div class="col-md-3 mb-4">
                    <div class="product-card">
                        <div class="product-card-img">
                                <label class="stock bg-danger">New Items</label>
                            @if ($relatedProductItem->productImages->count() > 0)
                                <a href="{{ url('/collections/'.$relatedProductItem->category->slug.'/'.$relatedProductItem->slug) }}">
                                    <img src="{{ asset($relatedProductItem->productImages[0]->image) }}" alt="{{ $relatedProductItem->name }}" />
                                </a>
                            @endif
                        </div>
                        <div class="product-card-body">
                            <p class="product-brand">{{ $relatedProductItem->brand }}</p>
                            <h5 class="product-name">
                                <a href="{{ url('/collections/'.$relatedProductItem->category->slug.'/'.$relatedProductItem->slug) }}">
                                    {{ $relatedProductItem->name }}
                                </a>
                            </h5>
                            <div>
                                <span class="selling-price">₱{{ $relatedProductItem->selling_price }}</span>
                                <span class="original-price">{{ $relatedProductItem->original_price }}</span>
                            </div>
                        </div>
                    </div>
                    </div>
                    @empty
                        <div class="col-md-12 p-2">
                            <h4>No Products Available</h4>
                        </div>
                    @endforelse
        </div>
    </div>
</div>           
@push('scripts')
    <script>
        $(function(){

            $("#exzoom").exzoom({

                // thumbnail nav options
                "navWidth": 60,
                "navHeight": 60,
                "navItemNum": 5,
                "navItemMargin": 7,
                "navBorder": 1,

                // autoplay
                "autoPlay": false,

                // autoplay interval in milliseconds
                "autoPlayTimeout": 2000
                
            });

            });
    </script>
@endpush