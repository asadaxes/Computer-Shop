<!DOCTYPE html>
<html lang="en">
<head>
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->ga_id }}"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '{{ $settings->ga_id }}');
</script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta name="author" content="{{ $settings->meta_author }}" />
@if(isset($product->meta_title))
@yield("product_meta_title")
@endif
@if(isset($product->meta_description))
@yield("product_meta_description")
@else
<meta name="description" content="{{ $settings->meta_description }}" />
@endif
<meta name="keywords" content="{{ $settings->meta_keywords }}" />
<link rel="shortcut icon" href="{{ Storage::url($settings->favicon) }}" />
<!-- all css -->
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}" />
<link rel="stylesheet" href="{{ asset('css/slick.css') }}" />
<link rel="stylesheet" href="{{ asset('css/line-awesome.css') }}" />
<link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
<title>@yield("title") | {{ $settings->title_site }}</title>
<style>
img.navbar_user_avatar{
  width: 50px;
  height: 50px;
  border-radius: 50%;
}
img.account_sidebar_avatar{
   width: 38px;
   height: 38px;
   border-radius: 50%;
}
ul#flash_msg_ul{
   margin: unset;
   padding: revert;
   list-style: unset;
}
.active>.page-link, .page-link.active{
   background-color: #f79f1f;
   border-color: #f79f1f;
}
</style>
@yield("style")
</head>
<body>
<!-- Preloader -->
<div class="preloader">
   <div class="window_loader"></div>
</div>
<header class="home-3">
   <div class="container-fluid">
      <div class="d-flex align-items-center justify-content-sm-between">
         <div class="logo">
            <a href="{{ route('home') }}">
            <img loading="lazy" src="{{ Storage::url($settings->logo_site) }}" />
            </a>
         </div>
         <div class="search_wrap d-none d-lg-block">
            <form action="{{ route('search_query') }}" method="GET">
               @csrf
               <div class="search d-flex">
                  <div class="search_input">
                     <input type="text" name="search" placeholder="Search" class="desktop_search_field" id="show_suggest" />
                  </div>
                  <div class="search_subimt">
                     <button type="submit">
                     <span class="d-none d-sm-inline-block">Search</span>
                     </button>
                  </div>
                  <div class="search_suggest shadow-sm">
                     <div class="search_result_product desktop_search_result">
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="header_icon d-flex align-items-center ms-auto ms-sm-0">
            <a href="{{ route('user_account_wishlist') }}" class="icon_wrp text-center wishlist ms-0">
            <span class="icon">
            <i class="icon-heart"></i>
            </span>
            <span class="icon_text">Wish List</span>
            <span class="pops">{{ Auth::check() ? auth()->user()->getWishlistProducts()->count() : 0 }}</span>
            </a>
            <div class="shopcart">
               <a href="javascript:void(0)" class="icon_wrp text-center d-none d-lg-block">
               <span class="icon">
               <i class="icon-cart"></i>
               </span>
               <span class="icon_text">Cart</span>
               <span class="pops cart_counter">0</span>
               </a>
               <div class="shopcart_dropdown">
                  <div class="cart_droptitle">
                     <h4 class="text_lg">Total <span class="cart_counter"></span> Items</h4>
                  </div>
                  <div class="cartsdrop_wrap">
                  </div>
                  <div class="total_cartdrop">
                     <h4 class="text_lg text-uppercase mb-0">Sub Total:</h4>
                     <h4 class="text_lg mb-0 ms-2 cart_subtotal">&#x9F3;0</h4>
                  </div>
                  <div class="cartdrop_footer d-flex mt-3">
                     <a href="{{ route('product_cart') }}" class="default_btn w-50 text_xs px-1">View Cart</a>
                     <a href="{{ route('product_checkout') }}" class="default_btn second ms-3 w-50 text_xs px-1">Checkout</a>
                  </div>
               </div>
            </div>
            <div class="position-relative myacwrap home-1">
               <a href="javascript:void(0)" class="icon_wrp text-center myacc">
               <span class="icon">
               <i class="icon-user-line"></i>
               </span>
               <span class="icon_text">Account</span>
               </a>
               <div class="myacc_cont">
                  @if(Auth::check())
                  <div class="ac_join border-bottom pb-2">
                     <div class="d-flex">
                        <img src="{{ Storage::url( auth()->user()->avatar ) }}" class="img-fluid navbar_user_avatar me-2">
                        <div class="d-flex flex-column">
                           <span>Hello,</span>
                           <h6>{{ auth()->user()->first_name }}</h6>
                        </div>
                     </div>
                  </div>
                  <div class="ac_links">
                     @if(auth()->user()->is_admin)
                     <a href="{{ route('admin_dashboard') }}" class="myac">
                     <i class="las la-user-shield"></i>
                     Admin Panel
                     </a>
                     @endif
                     <a href="{{ route('user_account') }}" class="myac">
                     <i class="lar la-id-card"></i>
                     My Account
                     </a>
                     <a href="{{ route('user_account_orders') }}">
                     <i class="las la-clipboard-list"></i>
                     Orders
                     </a>
                     <a href="{{ route('user_account_wishlist') }}">
                     <i class="lar la-heart"></i>
                     Wishlist
                     </a>
                     <a href="{{ route('product_cart') }}">
                     <i class="icon-cart"></i>
                     Cart
                     </a>
                     <a href="{{ route('logout') }}">
                     <i class="las la-power-off"></i>
                     Logout
                     </a>
                  </div>
                  @else
                  <div class="ac_join">
                     <p>Welcome to {{ env('APP_NAME') }}</p>
                     <div class="account_btn d-flex justify-content-between">
                        <a href="{{ route('register') }}" class="default_btn">Join</a>
                        <a href="{{ route('signin') }}" class="default_btn second">Sing in</a>
                     </div>
                  </div>
                  <div class="ac_links">
                     <a href="{{ route('product_cart') }}">
                     <i class="icon-cart"></i>
                     My Cart
                     </a>
                  </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</header>
<!-- navbar -->
<nav class="d-none d-lg-block home-3">
      <div class="d-flex">
         <div class="all_category">
            <div class="bars text-white d-flex align-items-center justify-content-center cursor_pointer">
               <span class="icon"><i class="las la-bars"></i></span>
               <span class="icon_text">All categories</span>
            </div>
            <div class="sub_categories">
               <h5 class="d-block position-relative d-lg-none subcats_title">All categories</h5>
               @if($categories)
                  @foreach($categories as $category)
                     @if($category->subcategories->isNotEmpty())
                        <div class="singlecats withsub">
                           <span class="txt">{{ $category->name }}</span>
                           <span class="wsicon"><i class="las la-angle-right"></i></span>
                           <div class="mega_menu pt-2 pb-1">
                              <div class="mega_menu_wrap mb-0">
                                 @foreach($category->subcategories as $subCategory)
                                    <a href="{{ route('search_query', ['search' => $subCategory->name]) }}" class="text-muted d-block mb-2">{{ $subCategory->name }}</a>
                                 @endforeach
                              </div>
                           </div>
                        </div>
                     @else
                        <a href="{{ route('search_query', ['search' => $category->name]) }}" class="singlecats">
                           <span class="txt">{{ $category->name }}</span>
                        </a>
                     @endif
                  @endforeach
               @endif
            </div>
         </div>
         <div class="container-fluid">
            <ul class="nav_bar flex-grow-1">
               <li class="withsubs"><a href="{{ route('home') }}">Home</a></li>
               <li class="withsubs"><a href="{{ route('brands_list') }}">Brands</a></li>
               <li class="withsubs"><a href="{{ route('track_order') }}">Track Order</a></li>
               <li class="withsubs"><a href="{{ route('best_deals') }}" class="text-danger">Best Deals</a></li>
               <li class="tophead_items ms-auto">
                  <a href="tel:{{ $settings->contact_phone }}" class="me-0 pe-0"><span><i class="las la-phone"></i></span>call: {{ $settings->contact_phone }}</a>
               </li>
            </ul>
         </div>
      </div>
</nav>
<!-- mobile bottom bar -->
<div class="mobile_bottombar d-block d-lg-none">
   <div class="header_icon">
      <a href="javascript:void(0)" class="icon_wrp text-center open_menu">
         <span class="icon">
            <i class="las la-bars"></i>
         </span>
         <span class="icon_text">Menu</span>
      </a>
      <a href="javascript:void(0)" class="icon_wrp text-center open_category">
         <span class="icon">
            <i class="icon-list-ul"></i>
         </span>
         <span class="icon_text">Categories</span>
      </a>
      <a href="javascript:void(0)" class="icon_wrp text-center" id="src_icon">
         <span class="icon">
            <i class="icon-search-left"></i>
         </span>
         <span class="icon_text">Search</span>
      </a>
      <a href="javascript:void(0)" class="icon_wrp crt text-center" id="openCart">
         <span class="icon">
            <i class="icon-cart"></i>
         </span>
         <span class="icon_text">Cart</span>
         <span class="pops cart_counter">0</span>
      </a>
   </div>
</div>
<!-- mobile menu -->
<div class="mobile_menwrap d-lg-none" id="mobile_menwrap">
   <div class="mobile_menu_2">
      <h5 class="mobile_title">Menu
         <span class="sidebarclose" id="menuclose">
            <i class="las la-times"></i>
         </span>
      </h5>
      <ul>
         <li class="withsubs"><a href="{{ route('home') }}">Home</a></li>
         <li class="withsubs"><a href="{{ route('brands_list') }}">Brands</a></li>
         <li class="withsubs"><a href="{{ route('track_order') }}">Track Order</a></li>
         <li class="withsubs"><a href="{{ route('best_deals') }}">Best Deals</a></li>
         <li class="withsubs"><a href=""><i class="las la-headset"></i> Help & Support</a></li>
         <li class="withsubs"><a href="tel:{{ $settings->contact_phone }}"><i class="las la-phone"></i> call: {{ $settings->contact_phone }}</a></li>
      </ul>
   </div>
</div>
<!--  mobile cart -->
<div class="mobile_menwrap d-lg-none" id="mobileCart">
   <div class="mobile_cart_wrap d-flex flex-column">
      <h5 class="mobile_title">Cart
         <span class="sidebarclose" id="mobileCartClose">
            <i class="las la-times"></i>
         </span>
      </h5>
      <div class="px-3 py-3 flex-grow-1 d-flex flex-column">
         <div class="cart_droptitle">
            <h4 class="text_lg">Total <span class="cart_counter"></span> Items</h4>
         </div>
         <div class="cartsdrop_wrap"></div>
         <div class="mt-auto">
            <div class="total_cartdrop">
               <h4 class="text_lg text-uppercase mb-0">Sub Total:</h4>
               <h4 class="text_lg mb-0 ms-2 cart_subtotal">&#x9F3;0</h4>
            </div>
            <div class="cartdrop_footer mt-3 d-flex">
               <a href="{{ route('product_cart') }}" class="default_btn w-50 text_xs px-1">View Cart</a>
               <a href="{{ route('product_checkout') }}" class="default_btn second ms-3 w-50 text_xs px-1">Checkout</a>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- mobile searchbar -->
<div class="mobile_search_bar">
   <div class="mobile_search_text">
      <p>What you are looking for?</p>
      <span class="close_mbsearch" id="close_mbsearch">
         <i class="las la-times"></i>
      </span>
   </div>
   <form action="{{ route('search_query') }}" method="GET">
      @csrf
      <input type="text" name="search" placeholder="search products..." id="mobile_search_field" />
      <button type="submit"><i class="icon-search-left"></i></button>
   </form>
   <div class="search_result_product" id="mobile_search_result"></div>
</div>
<!-- Mobile View -->
<div class="mobile_menwrap d-lg-none" id="mobile_catwrap">
   <div class="sub_categories">
      <h5 class="mobile_title">
         All categories
         <span class="sidebarclose" id="catclose">
            <i class="las la-times"></i>
         </span>
      </h5>
      @if($categories)
         @foreach($categories as $category)
            @if($category->subcategories->isNotEmpty())
               <div class="singlecats withsub">
                  <span class="txt">{{ $category->name }}</span>
                  <span class="wsicon"><i class="las la-angle-right"></i></span>
                  <div class="mega_menu">
                     <div class="mega_menu_wrap">
                        @foreach($category->subcategories as $subCategory)
                           <a href="{{ route('search_query', ['search' => $subCategory->name]) }}" class="text-muted d-block mb-2">{{ $subCategory->name }}</a>
                        @endforeach
                     </div>
                  </div>
               </div>
            @else
               <a href="{{ route('search_query', ['search' => $category->name]) }}" class="singlecats">
                  <span class="txt">{{ $category->name }}</span>
               </a>
            @endif
         @endforeach
      @endif
   </div>
</div>

@yield("content")

@if(session("success"))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div class="toast @if(session('success')) bg-success @elseif(session('info')) bg-info @else bg-danger @endif text-white" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body d-flex justify-content-between">
      <span>{{ session("success") }}</span>
    </div>
  </div>
</div>
@endif
@if(session("info"))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div class="toast @if(session('success')) bg-success @elseif(session('info')) bg-info @else bg-danger @endif text-white" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body d-flex justify-content-between">
      <span>{{ session("info") }}</span>
    </div>
  </div>
</div>
@endif
@if(session("error"))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div class="toast @if(session('success')) bg-success @elseif(session('info')) bg-info @else bg-danger @endif text-white" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body d-flex justify-content-between">
      <span>{{ session("error") }}</span>
    </div>
  </div>
</div>
@endif
@if($errors->any())
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body d-flex justify-content-between">
      <ul class="mb-0" id="flash_msg_ul">
        @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
@endif
<footer class="bg-light colored pb-0">
   <div class="container mb-5">
      <div class="row">
         <div class="col-lg-4 mb-4 mb-md-0">
            <div class="row">
               <div class="col-12 col-md-6 col-lg-12">
                  <div class="footer_logo">
                     <img src="{{ Storage::url($settings->logo_site) }}" class="img-fluid">
                  </div>
                  <div class="footet_text">
                     <p>{{ $settings->footer_description }}</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 mb-3 mb-md-0">
            <div class="row">
               <div class="col-6">
                  <div class="footer_menu">
                     <h4 class="footer_title">My Account</h4>
                     <a href="{{ route('user_account_orders') }}">Orders</a>
                     <a href="{{ route('user_account_wishlist') }}">Wishlist</a>
                     <a href="{{ route('track_order') }}">Track Order</a>
                     <a href="{{ route('user_account') }}">Manage Account</a>
                  </div>
               </div>
               <div class="col-6">
                  <div class="footer_menu">
                     <h4 class="footer_title">Information</h4>
                     @foreach($pages as $page)
                     <a href="{{ route('page_details', ['slug' => $page->slug]) }}">{{ $page->name }}</a>
                     @endforeach
                     <a href="{{ route('faq') }}">FAQ</a>
                  </div>
               </div>
            </div>
         </div>
{{--         <div class="col-lg-4">--}}
{{--            <div class="footer_download">--}}
{{--               <div class="row">--}}
{{--                  <div class="col-lg-6 col-lg-12">--}}
{{--                     <h4 class="footer_title">Contact</h4>--}}
{{--                     <div class="footer_contact">--}}
{{--                        <p>--}}
{{--                           <span class="icn"><i class="las la-map-marker-alt"></i></span>--}}
{{--                           {{ $settings->contact_address }}--}}
{{--                        </p>--}}
{{--                        <p class="phn">--}}
{{--                           <span class="icn"><i class="las la-phone"></i></span>--}}
{{--                           {{ $settings->contact_phone }}--}}
{{--                        </p>--}}
{{--                        <p class="eml">--}}
{{--                           <span class="icn"><i class="lar la-envelope"></i></span>--}}
{{--                           {{ $settings->contact_email }}--}}
{{--                        </p>--}}
{{--                     </div>--}}
{{--                  </div>--}}
{{--                  <div class="footer_social col-lg-6 col-lg-12">--}}
{{--                     <div class="footer_icon d-flex">--}}
{{--                        @if (!empty($settings->social_ids))--}}
{{--                        @php--}}
{{--                        $socialLinks = json_decode($settings->social_ids, true);--}}
{{--                        @endphp--}}
{{--                        @foreach ($socialLinks as $link)--}}
{{--                        <a href="{{ $link['url'] }}" class="{{ $link['platform'] }}"target="_blank"><i class="lab la-{{ $link['platform'] }}"></i></a>--}}
{{--                        @endforeach--}}
{{--                        @endif--}}
{{--                     </div>--}}
{{--                  </div>--}}
{{--               </div>--}}
{{--            </div>--}}
{{--         </div>--}}
{{--          @php--}}
{{--              dd($settings->social_ids);--}}
{{--          @endphp--}}
{{--          @php--}}
{{--              $socialLinks = json_decode($settings->social_ids, true);--}}
{{--              dd($socialLinks);--}}
{{--          @endphp--}}
          <div class="col-lg-4">
              <div class="footer_download">
                  <div class="row">
                      <div class="col-lg-6 col-lg-12">
                          <h4 class="footer_title">Contact</h4>
                          <div class="footer_contact">
                              <p>
                                  <span class="icn"><i class="las la-map-marker-alt"></i></span>
                                  {{ $settings->contact_address }}
                              </p>
                              <p class="phn">
                                  <span class="icn"><i class="las la-phone"></i></span>
                                  {{ $settings->contact_phone }}
                              </p>
                              <p class="eml">
                                  <span class="icn"><i class="lar la-envelope"></i></span>
                                  {{ $settings->contact_email }}
                              </p>
                          </div>
                      </div>
                      <div class="footer_social col-lg-6 col-lg-12">
                          <div class="footer_icon d-flex">
                              @if (!empty($settings->social_ids))
                                  @php
                                      $socialLinks = json_decode($settings->social_ids, true);  // Decode as an associative array
                                  @endphp
                                  @if (is_array($socialLinks))
                                      @foreach ($socialLinks as $platform => $id)
                                          <a href="https://{{ $platform }}.com/{{ $id }}" class="{{ $platform }}" target="_blank">
                                              <i class="lab la-{{ $platform }}"></i>
                                          </a>
                                      @endforeach
                                  @endif
                              @endif
                          </div>
                      </div>
                  </div>
              </div>
          </div>


          <div class="col-12 text-center mt-5">
            <h6 class="footet_text mb-1">pay with your choice</h6>
            <img src="{{ asset('assets/payment_methods.png') }}" class="img-fluid" width="450px">
         </div>
      </div>
   </div>
   <div class="container-fluid">
      <div class="copyright_wrap text-center">
         <p class="mb-0 pb-2">{{ $settings->footer_copyright }}</p>
      </div>
   </div>
</footer>
<!-- back to top -->
<button id="back-to-top" class="back-to-top-hide">
	<i class="las la-arrow-up"></i>
</button>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src="{{ env('TAWK_CHAT_URI') }}";
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!-- all js -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
@if(session('payment_successful_clean_cart'))
   document.addEventListener('DOMContentLoaded', function() {
   localStorage.removeItem('cart');
   fetch('{{ route('clear_payment_success_session') }}')
      .then(response => response.json())
      .then(data => console.log(data.message))
      .catch(error => console.error('Error:', error));
   });
@endif

document.addEventListener("DOMContentLoaded", function() {
   let toastElement = document.querySelector(".toast");
   if (toastElement) {
      let toast = new bootstrap.Toast(toastElement);
      toast.show();
   }

   let cart = JSON.parse(localStorage.getItem('cart')) || [];
   function updateCartBadge() {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      let totalItems = cart.length;
      if (totalItems > 0) {
         $('.cart_counter').text(totalItems);
      } else {
         $('.cart_counter').text(0);
      }
   }

   function truncateTitle(title) {
        if (title.length > 30) {
            return title.substring(0, 30) + '...';
        }
        return title;
    }

   function updateCartView() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let cartItemsContainer = $('.cartsdrop_wrap');
        cartItemsContainer.empty();
        let subtotal = 0;
        cart.forEach(function(item) {
            let cartItemHtml = `
                <div class="single_cartdrop mb-3">
                    <span class="remove_cart" data-id="${item.id}"><i class="las la-times"></i></span>
                    <div class="cartdrop_img">
                        <img loading="lazy" src="${item.image}" />
                    </div>
                    <div class="cartdrop_cont">
                        <h5 class="text_lg mb-0 default_link"><a href="/product/${item.slug}">${truncateTitle(item.title)}</a></h5>
                        <p class="mb-0 text_xs text_p">x${item.quantity} <span class="ms-2">$${item.price}</span></p>
                    </div>
                </div>
            `;
            cartItemsContainer.append(cartItemHtml);
            subtotal += item.price * item.quantity;
        });
        $('.cart_subtotal').html('&#x9F3;'+subtotal);
        $('.remove_cart').click(function() {
            let productId = $(this).data('id');
            removeFromCart(productId);
        });
    }

    function removeFromCart(productId) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let updatedCart = cart.filter(item => item.id !== productId);
        localStorage.setItem('cart', JSON.stringify(updatedCart));
        updateCartBadge();
        updateCartView();
    }

   function updateButtons() {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      $('.add_to_cart_btn').each(function() {
         let productId = $(this).data('id');
         let inCart = cart.some(item => item.id === productId);
         if (inCart) {
         $(this).removeClass('default_btn');
         $(this).addClass('btn btn-success');
         $(this).html('<i class="las la-check"></i> Added to Cart');
         $(this).attr('disabled', true);
      }
      });
   }
   updateButtons();
   updateCartBadge();
   updateCartView();

   $('.add_to_cart_btn').on('click', function() {
      let product = {
         id: $(this).data('id'),
         title: $(this).data('title'),
         slug: $(this).data('slug'),
         image: $(this).data('image'),
         price: $(this).data('price'),
         quantity: $(this).data('quantity')
      };
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      let existingProductIndex = cart.findIndex(item => item.id === product.id);
      if (existingProductIndex !== -1) {
         cart[existingProductIndex].quantity += 1;
      } else {
         cart.push(product);
      }
      localStorage.setItem('cart', JSON.stringify(cart));
      updateButtons();
      updateCartBadge();
      updateCartView();
   });

   function performSearch(searchFieldSelector, resultContainerSelector) {
      $(searchFieldSelector).on('keyup', function() {
         let query = $(this).val();
         if (query.length > 2) {
            $.ajax({
               url: "{{ route('search_query_live') }}",
               type: 'GET',
               data: { query: query },
               success: function(data) {
                  $(resultContainerSelector).empty();
                  if (data.length > 0) {
                     data.forEach(function(product) {
                        let productHtml = `
                           <a href="/product/${product.slug}" class="single_sresult_product">
                              <div class="sresult_img">
                                 <img loading="lazy" src="${product.image}" />
                              </div>
                              <div class="sresult_content">
                                 <h4>${product.title}</h4>
                                 <div class="price">
                                    <span class="org_price">&#x9F3;${product.sale_price}</span>
                                 </div>
                              </div>
                           </a>`;
                        $(resultContainerSelector).append(productHtml);
                     });
                  } else {
                     $(resultContainerSelector).append("<p class='text-center text-muted py-2 mb-0'>No products found</p>");
                  }
               }
            });
         } else {
            $(resultContainerSelector).empty();
         }
      });
   }

   performSearch('.desktop_search_field', '.desktop_search_result');
   performSearch('#mobile_search_field', '#mobile_search_result');
});

function getSearchBarUrl() {
   let urlParams = new URLSearchParams(window.location.search);
   return urlParams.get('search') || '';
}
document.addEventListener('DOMContentLoaded', function() {
   document.querySelector('.desktop_search_field').value = getSearchBarUrl();
   document.querySelector('#mobile_search_field').value = getSearchBarUrl();
});
</script>
@yield("script")
</body>
</html>
