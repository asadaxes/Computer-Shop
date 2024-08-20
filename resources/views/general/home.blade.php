@extends("general_base")
@section("title") #1 Computer Shop in Bangladesh @endsection
@section("style")
<style>
.gaming_banner_parallax {
   width: 100%;
   max-width: 100%;
   overflow: hidden;
   position: relative;
   background-image: url('{{ Storage::url($layout->parallax_banner) }}');
   background-attachment: fixed;
   background-position: center;
   background-repeat: no-repeat;
   background-size: 100% auto;
   border-radius: 10px;
}
@media only screen and (min-width: 380px) {
   .gaming_banner_parallax {
      height: 250px;
   }
}
@media only screen and (min-width: 480px) {
   .gaming_banner_parallax {
      height: 350px;
   }
}
@media only screen and (min-width: 720px) {
   .gaming_banner_parallax {
      height: 425px;
   }
}
@media only screen and (min-width: 1024px) {
   .gaming_banner_parallax {
      height: 525px;
   }
}
@media only screen and (min-width: 1440px) {
   .gaming_banner_parallax {
      height: 650;
   }
}
</style>
@endsection
@section("content")
<div class="container-fluid home_2_hero_wrp home-3">
    <div class="row">
       <div class="col-xl-9">
          <div class="home_2_hero">
             <div class="container">
                <div class="hero_slider_active">
                  @foreach(json_decode($layout->header_sliders, true) as $slider)
                   <div class="single_hero_slider">
                      <div class="hero_img" style="background-image: url('{{ Storage::url($slider) }}');">
                      </div>
                   </div>
                  @endforeach
                </div>
             </div>
          </div>
       </div>
       <div class="col-xl-3">
          <div class="banner_collection mt-5 pt-2 pt-xl-0 mt-xl-0 d-flex flex-xl-column flex-row gap-3">
             <a href="javascript:void(0)" class="single_bannercol rounded">
                {!! $layout->fp_text_1 !!}
                <div class="bancol_img">
                   <img loading="lazy" src="{{ Storage::url($layout->fp_img_1) }}" />
                </div>
             </a>
             <a href="javascript:void(0)" class="single_bannercol rounded">
               {!! $layout->fp_text_2 !!}
                <div class="bancol_img">
                   <img loading="lazy" src="{{ Storage::url($layout->fp_img_2) }}" />
                </div>
             </a>
          </div>
       </div>
    </div>
 </div>
 <!-- features area -->
 <section class="features_area section_padding">
    <div class="container">
       <div class="row justify-content-center">
          <div class="col-xl-10">
            @php
               $conteiner = json_decode($layout->container, true);
            @endphp
             <div class="row justify-content-center gx-2 gx-md-4">
                <div class="col-sm-4 mb-3 mb-sm-0">
                   <div class="single_feature d-flex flex-column flex-sm-row align-items-center justify-content-center">
                      <div class="feature_icon">
                         <img loading="lazy" src="{{ asset('assets/icons/delivery_bike.png') }}" alt="icon" />
                      </div>
                      <div class="feature_content">
                        <h4>{{ $conteiner[0]['h'] ?? '' }}</h4>
                        <p>{{ $conteiner[0]['p'] ?? '' }}</p>
                      </div>
                   </div>
                </div>
                <div class="col-sm-4 mb-3 mb-sm-0">
                   <div class="single_feature d-flex flex-column flex-sm-row align-items-center justify-content-center">
                      <div class="feature_icon">
                         <img loading="lazy" src="{{ asset('assets/icons/money_back.png') }}" alt="icon" />
                      </div>
                      <div class="feature_content">
                        <h4>{{ $conteiner[1]['h'] ?? '' }}</h4>
                        <p>{{ $conteiner[1]['p'] ?? '' }}</p>
                      </div>
                   </div>
                </div>
                <div class="col-sm-4">
                   <div class="single_feature d-flex flex-column flex-sm-row align-items-center justify-content-center">
                      <div class="feature_icon">
                         <img loading="lazy" src="{{ asset('assets/icons/24_hour_service.png') }}" alt="icon" />
                      </div>
                      <div class="feature_content">
                        <h4>{{ $conteiner[2]['h'] ?? '' }}</h4>
                        <p>{{ $conteiner[2]['p'] ?? '' }}</p>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
@if($flash_sale->status == "Upcoming")
<div class="top_arrival_wrp home-3 section_padding_b">
   <div class="container">
      <h2 class="section_title_3">Flash sale</h2>
      <div class="d-flex align-items-center justify-content-between mb-4">
         <div class="flash_counter">
            <div class="end_in">Starts on</div>
            <div class="single_count" id="count_days">0d</div>
            <div class="time_sep">:</div>
            <div class="single_count" id="count_hour">00h</div>
            <div class="time_sep">:</div>
            <div class="single_count" id="count_minute">00m</div>
            <div class="time_sep">:</div>
            <div class="single_count" id="count_second">00s</div>
         </div>
      </div>
   </div>
</div>
@elseif($flash_sale->status == "Active")
 <!-- top new arrival -->
<div class="top_arrival_wrp home-3 section_padding_b">
   <div class="container">
      <h2 class="section_title_3">Flash sale</h2>
      <div class="d-flex align-items-center mb-4">
         <div class="flash_counter">
            <div class="end_in">Ending in</div>
            <div class="single_count" id="count_days">0d</div>
            <div class="time_sep">:</div>
            <div class="single_count" id="count_hour">00h</div>
            <div class="time_sep">:</div>
            <div class="single_count" id="count_minute">00m</div>
            <div class="time_sep">:</div>
            <div class="single_count" id="count_second">00s</div>
        </div>        
      </div>      
      <div class="product_slider_2">
         @foreach($flash_sale_products as $rcp)
         @php
            $img = json_decode($rcp->images, true);
         @endphp
         @auth
         @php
         $wishlistIds = auth()->check() ? auth()->user()->wishlist->pluck('product_id')->toArray() : [];
         $inWishlist = in_array($rcp->id, $wishlistIds);
         @endphp
         @endauth
            <div class="single_toparrival">
               <div class="single_new_arrive">
                  <div class="sna_img">
                      <a href="{{ route('product_view', ['slug' => $rcp->slug]) }}">
                          <img loading="lazy" class="prd_img" src="{{ Storage::url($img[0]) }}" />
                      </a>
                      @if($rcp->quantity === 0)
                        <span class="tag">Stock Out</span>
                      @endif
                      <div class="prodcut_hovcont">
                          <a href="{{ route('product_wishlist_updater', ['id' => $rcp->id]) }}" class="icon" tabindex="0">
                           @auth
                              <i class="las {{ $inWishlist ? 'la-minus-circle la-lg' : 'la-heart' }}"></i>
                           @else
                              <i class="las la-heart"></i>
                           @endauth
                          </a>
                      </div>
                  </div>
                  <div class="sna_content">
                      <a href="{{ route('product_view', ['slug' => $rcp->slug]) }}">
                          <h6>{{ Str::limit($rcp->title, 50) }}</h6>
                       </a>
                      <div class="ratprice mt-3">
                          <div class="price d-flex align-items-center">
                              @if($rcp->regular_price)
                              <span class="prev_price ms-0">&#x9F3;{{ $rcp->regular_price }}</span>
                              @endif
                              <span class="org_price ms-2">&#x9F3;{{ $rcp->sale_price }}</span>
                              @if($rcp->regular_price)
                              <div class="disc_tag ms-3">-{{ number_format((($rcp->regular_price - $rcp->sale_price) / $rcp->regular_price) * 100, 0) }}%</div>
                              @endif
                          </div>
                      </div>
                      <div class="product_adcart">
                        @if($rcp->quantity > 0)
                           <button type="button" class="default_btn add_to_cart_btn" 
                              data-id="{{ $rcp->id }}" 
                              data-title="{{ $rcp->title }}" 
                              data-slug="{{ $rcp->slug }}" 
                              data-image="{{ Storage::url($img[0]) }}" 
                              data-price="{{ $rcp->sale_price }}" 
                              data-quantity="1"><i class="icon-cart me-2"></i> Add to Cart</button>
                        @else
                           <button class="btn btn-danger" disabled>Out of Stock</button>
                        @endif
                      </div>
                  </div>
              </div>
            </div>
         @endforeach
      </div>
   </div>
</div>
@elseif($flash_sale->status == "Expired")
<div class="top_arrival_wrp home-3 section_padding_b">
   <div class="container">
      <h2 class="section_title_3">Flash sale</h2>
      <div class="d-flex align-items-center justify-content-between mb-4">
         <div class="flash_counter">
            <div class="end_in">Ended</div>
            <div class="single_count">00</div>
            <div class="time_sep">:</div>
            <div class="single_count">00</div>
            <div class="time_sep">:</div>
            <div class="single_count">00</div>
            <div class="time_sep">:</div>
            <div class="single_count">00</div>
        </div>
      </div>
   </div>
</div>
@endif
 <!-- accessories -->
 <div class="category_2 section_padding_b">
    <div class="container">
       <h2 class="section_title_3">Accessories</h2>
       <div class="row gy-4">
         @foreach ($ac_list as $list)
            <div class="col-xl-2 col-md-3 col-sm-4 col-6">
               <a href="{{ route('search_query', ['search' => $list->name]) }}">
                  <div class="single_category_2">
                     <div class="cat2_img">
                        <img loading="lazy" src="{{ Storage::url($list->icon) }}" />
                     </div>
                     <h5>{{ $list->name }}</h5>
                  </div>
               </a>
            </div>
         @endforeach
       </div>
    </div>
 </div>
 <!-- gaming banner -->
 <div class="section_padding_b">
    <div class="container-fluid">
       <div class="gaming_banner_parallax">
       </div>
    </div>
 </div>
@if($recommended_products->isNotEmpty())
 <!-- recomended -->
 <div class="top_arrival_wrp home-3 section_padding_b">
   <div class="container">
      <h2 class="section_title_3">recomended for you</h2>
      <div class="product_slider_2">
      @foreach($recommended_products as $rcp)
      @php
         $img = json_decode($rcp->images, true);
      @endphp
      @auth
      @php
      $wishlistIds = auth()->check() ? auth()->user()->wishlist->pluck('product_id')->toArray() : [];
      $inWishlist = in_array($rcp->id, $wishlistIds);
      @endphp
      @endauth
         <div class="single_toparrival">
            <div class="single_new_arrive">
               <div class="sna_img">
                   <a href="{{ route('product_view', ['slug' => $rcp->slug]) }}">
                       <img loading="lazy" class="prd_img" src="{{ Storage::url($img[0]) }}" />
                   </a>
                   @if($rcp->quantity === 0)
                     <span class="tag">Stock Out</span>
                   @endif
                   <div class="prodcut_hovcont">
                     <a href="{{ route('product_wishlist_updater', ['id' => $rcp->id]) }}" class="icon" tabindex="0">
                        @auth
                           <i class="las {{ $inWishlist ? 'la-minus-circle la-lg' : 'la-heart' }}"></i>
                        @else
                           <i class="las la-heart"></i>
                        @endauth
                     </a>
                   </div>
               </div>
               <div class="sna_content">
                   <a href="{{ route('product_view', ['slug' => $rcp->slug]) }}">
                       <h6>{{ Str::limit($rcp->title, 50) }}</h6>
                    </a>
                   <div class="ratprice mt-3">
                       <div class="price d-flex align-items-center">
                        @if($rcp->regular_price)
                        <span class="prev_price ms-0">&#x9F3;{{ $rcp->regular_price }}</span>
                        @endif
                        <span class="org_price ms-2">&#x9F3;{{ $rcp->sale_price }}</span>
                        @if($rcp->regular_price)
                        <div class="disc_tag ms-3">-{{ number_format((($rcp->regular_price - $rcp->sale_price) / $rcp->regular_price) * 100, 0) }}%</div>
                        @endif
                       </div>
                   </div>
                   <div class="product_adcart">
                     @if($rcp->quantity > 0)
                     <button type="button" class="default_btn add_to_cart_btn" 
                        data-id="{{ $rcp->id }}" 
                        data-title="{{ $rcp->title }}" 
                        data-slug="{{ $rcp->slug }}" 
                        data-image="{{ Storage::url($img[0]) }}" 
                        data-price="{{ $rcp->sale_price }}" 
                        data-quantity="1"><i class="icon-cart me-2"></i> Add to Cart</button>
                     @else
                        <button class="btn btn-danger" disabled>Out of Stock</button>
                     @endif
                   </div>
               </div>
           </div>
         </div>
      @endforeach
      </div>
   </div>
 </div>
@endif
<!-- best selling -->
<div class="best_selling section_padding_b">
   <div class="container">
      <div class="row">
         <div class="col-md-6 mb-md-0 mb-4">
            <div class="bestprod_title d-flex align-items-center">
               <div class="text_xl text-uppercase text-semibold">Best Selling</div>
            </div>
            <div class="bestprod_wrp">
               @foreach($best_sales as $pd)
               @php 
                  $images = json_decode($pd->images, true);
               @endphp
               <div class="single_bestprod">
                  <div class="bestprod_img">
                     <a href="{{ route('product_view', ['slug' => $pd->slug]) }}">
                        <img loading="lazy" src="{{ Storage::url($images[0]) }}" />
                     </a>
                  </div>
                  <div class="bestprod_content">
                     <a href="{{ route('product_view', ['slug' => $pd->slug]) }}" class="default_link">
                        <h4 class="text_lg mb-2">{{ Str::limit($pd->title, 70) }}</h4>
                     </a>
                     <div class="price mb-0">
                        @if($pd->regular_price)
                           <span class="prev_price ms-0">&#x9F3;{{ $pd->regular_price }}</span>
                        @endif
                           <span class="org_price ms-2">&#x9F3;{{ $pd->sale_price }}</span>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
         <div class="col-md-6">
            <div class="bestprod_title d-flex align-items-center">
               <div class="text_xl text-uppercase text-semibold">Latest</div>
            </div>
            <div class="bestprod_wrp">
               @foreach($latest_products as $pd)
               @php 
                  $images = json_decode($pd->images, true);
               @endphp
               <div class="single_bestprod">
                  <div class="bestprod_img">
                     <a href="{{ route('product_view', ['slug' => $pd->slug]) }}">
                        <img loading="lazy" src="{{ Storage::url($images[0]) }}" />
                     </a>
                  </div>
                  <div class="bestprod_content">
                     <a href="{{ route('product_view', ['slug' => $pd->slug]) }}" class="default_link">
                        <h4 class="text_lg mb-2">{{ Str::limit($pd->title, 70) }}</h4>
                     </a>
                     <div class="price mb-0">
                        @if($rcp->regular_price)
                           <span class="prev_price ms-0">&#x9F3;{{ $rcp->regular_price }}</span>
                        @endif
                           <span class="org_price ms-2">&#x9F3;{{ $rcp->sale_price }}</span>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section("script")
<script>
@if($flash_sale->status == "Upcoming" || $flash_sale->status == "Active")
function startTimer(endTime) {
   let interval = setInterval(function () {
      let now = new Date().getTime();
      let timeRemaining = endTime - now;
      if (timeRemaining <= 0) {
         clearInterval(interval);
         $('#count_days').text('00d');
         $('#count_hour').text('00h');
         $('#count_minute').text('00m');
         $('#count_second').text('00s');
         return;
      }
      let days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
      let hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      let minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
      let seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
      $('#count_days').text((days < 10 ? + days : days) + 'd');
      $('#count_hour').text((hours < 10 ? '0' + hours : hours) + 'h');
      $('#count_minute').text((minutes < 10 ? '0' + minutes : minutes) + 'm');
      $('#count_second').text((seconds < 10 ? '0' + seconds : seconds) + 's');
   }, 1000);
}
let endTime = new Date("{{ $flash_sale->status == 'Upcoming' ? $flash_sale->from_date : $flash_sale->to_date }}").getTime();
startTimer(endTime);
@endif
</script>
@endsection