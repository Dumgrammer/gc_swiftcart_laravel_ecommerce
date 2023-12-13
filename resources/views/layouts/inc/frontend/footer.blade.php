<div>
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h4 class="footer-heading">{{$appSetting->website_name ?? 'GC Swiftcart'}}</h4>
                    <div class="footer-underline"></div>
                    <p>
                        {{$appSetting->meta_description ?? 'GC Swiftcart'}}
                </div>
                <div class="col-md-3">
                    <h4 class="footer-heading">Quick Links</h4>
                    <div class="footer-underline"></div>
                    <div class="mb-2"><a href="{{url('/')}}" class="text-white">Home</a></div>
                    <div class="mb-2"><a href="{{url('/about-us')}}" class="text-white">About Us</a></div>
                    <div class="mb-2"><a href="{{url('/contact-us')}}" class="text-white">Contact Us</a></div>
                    <div class="mb-2"><a href="{{url('/blogs')}}" class="text-white">Blogs</a></div>
                    <div class="mb-2"><a href="{{url('/sitestamps')}}" class="text-white">Sitemaps</a></div>
                </div>
                <div class="col-md-3">
                    <h4 class="footer-heading">Shop Now</h4>
                    <div class="footer-underline"></div>
                    <div class="mb-2"><a href="{{url('/collections')}}" class="text-white">Collections</a></div>
                    <div class="mb-2"><a href="{{url('/trending-products')}}" class="text-white">Trending Products</a></div>
                    <div class="mb-2"><a href="{{url('/new-arrivals')}}" class="text-white">New Arrivals Products</a></div>
                    <div class="mb-2"><a href="{{url('/featured-products')}}" class="text-white">Featured Products</a></div>
                    <div class="mb-2"><a href="{{url('/cart')}}" class="text-white">Cart</a></div>
                </div>
                <div class="col-md-3">
                    <h4 class="footer-heading">Reach Us</h4>
                    <div class="footer-underline"></div>
                    <div class="mb-2">
                        <p>
                            <i class="fa fa-map-marker"></i>{{$appSetting->address ?? "#2208, Blk 35 Lot 27 Ph3 Miami Street Hanjin Village Catillejos Zambales Philippines"}} 
                        </p>
                    </div>
                    <div class="mb-2">
                        <a href="" class="text-white">
                            <i class="fa fa-phone"></i> {{$appSetting->number1 ?? '+639700998789'}}
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="" class="text-white">
                            <i class="fa fa-envelope"></i> {{$appSetting->email1 ?? 'bastianlacap55@gmail.com'}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p class=""> &copy; 2022 - Intelliware. All rights reserved.</p>
                </div>
                <div class="col-md-4">
                    <div class="social-media">
                        Get Connected:
                        {{$appSetting->website_name ?? 'GC Swiftcart'}}
                        @if ($appSetting->facebook)
                        <a href="{{$appSetting->facebook}}" target="_blank"><i class="fa fa-facebook"></i></a>
                        @endif
                        @if ($appSetting->twitter)
                        <a href="{{$appSetting->twiiter}}" target="_blank"><i class="fa fa-twitter"></i></a>
                        @endif
                        @if ($appSetting->instagram)
                        <a href="{{$appSetting->instagram}}" v><i class="fa fa-instagram" ></i></a>
                        @endif
                        @if ($appSetting->youtube)
                        <a href="{{$appSetting->youtube}}" target="_blank"><i class="fa fa-youtube" ></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>