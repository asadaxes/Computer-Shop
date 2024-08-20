@extends("general_base")
@section("title") ComputerShop - {{ $product->title }} @endsection
@section("style")
<style>
div.product_info_wrapper{
    box-shadow: 0px 0px 5px 1px rgba(0,0,0,.075)!important;
}
ul#featured_list{
    margin: unset;
    padding: revert;
    list-style: unset;
    color: #686868;
}
table{
    line-height: 30px;
}
div.progress_container{
    line-height: 1;
}
div.progress{
    width: 200px;
    height: 5px;
}
</style>
@endsection
@section("content")
@php 
$images = json_decode($product->images, true);
$tags = json_decode($product->tags, true);

if (is_string($product->featured)) {
    $featured = json_decode($product->featured, true);
} elseif (is_array($product->featured)) {
    $featured = $product->featured;
} else {
    $featured = [];
}
if (is_string($product->specification)) {
    $specification = json_decode($product->specification, true);
} elseif (is_array($product->specification)) {
    $specification = $product->specification;
} else {
    $specification = [];
}
@endphp
@auth
@php
$wishlistIds = auth()->user()->wishlist->pluck('product_id')->toArray();
$inWishlist = in_array($product->id, $wishlistIds);
@endphp
@endauth
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('search_query', ['search' => $product->category->name]) }}">{{ $product->category->name }}</a>
        @if($product->sub_category_id)
        <a href="{{ route('search_query', ['search' => $product->subCategory->name]) }}">{{ $product->subCategory->name }}</a>
        @endif
		<a href="" class="active">{{ $product->title }}</a>
	</div>
</div>
<!-- product view -->
<div class="product_view_wrap section_padding_b">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product_view_slider">
                    <div class="single_viewslider">
                        <img src="{{ Storage::url($images[0]) }}" id="main_image">
                    </div>
                </div>
                <div class="product_viewslid_nav">
                    @foreach($images as $img)
                    <div class="single_viewslid_nav">
                        <img src="{{ Storage::url($img) }}" class="cursor_pointer thumbnail">
                    </div>
                    @endforeach
                </div>                
            </div>
            <div class="col-lg-6">
                <div class="product_info_wrapper card card-body border-0">
                    <div class="product_base_info">
                        <h1>{{ $product->title }}</h1>
                        <div class="product_other_info">
                            <div class="d-flex align-items-center">
                                <span>Availability:</span> 
                                <div class="text-center progress_container">
                                    <small class="{{ $product->quantity > 10 ? 'text-success' : 'text-danger' }}">{{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}</small>
                                    <div class="progress ms-2" role="progressbar">
                                        <div class="progress-bar {{ $product->quantity > 10 ? 'bg-success' : 'bg-danger' }}" style="width: {{ min(100, ($product->quantity / 25) * 100) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="price mt-3 mb-3 d-flex align-items-center">
                            @if($product->regular_price)
                            <span class="prev_price ms-0">&#x9F3;{{ $product->regular_price }}</span>
                            <span class="org_price ms-2">&#x9F3;{{ $product->sale_price }}</span>
                            <div class="disc_tag ms-3">-{{ number_format((($product->regular_price - $product->sale_price) / $product->regular_price) * 100, 0) }}%</div>
                            @else
                            <span class="org_price ms-2">&#x9F3;{{ $product->sale_price }}</span>
                            @endif
                        </div>
                        @if(!empty($featured))
                        <div class="shop_filter border-bottom-0 pb-0">
                            <small>
                                <ul id="featured_list">
                                    @foreach($featured as $item)
                                    <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </small>
                        </div>
                        @endif
                        <div class="cart_qnty ms-md-auto">
                            <p>Quantity</p>
                            <div class="d-flex align-items-center">
                                <div class="cart_qnty_btn" id="quantity_btn_minus">
                                    <i class="las la-minus"></i>
                                </div>
                                <div class="cart_count" id="quantity_display">1</div>
                                <input type="hidden" id="quantity_field" value="1" min="1" max="{{ $product->quantity }}" value="{{ $product->quantity === 0 ? 0 : 1 }}">
                                <div class="cart_qnty_btn" id="quantity_btn_plus">
                                    <i class="las la-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product_buttons">
                        @if($product->quantity > 0)
                        <button type="button" class="default_btn small rounded me-sm-3 me-2 px-4 add_to_cart_btn" 
                            data-id="{{ $product->id }}" 
                            data-title="{{ $product->title }}" 
                            data-slug="{{ $product->slug }}" 
                            data-image="{{ Storage::url($images[0]) }}" 
                            data-price="{{ $product->sale_price }}" 
                            data-quantity="1"><i class="icon-cart me-2"></i> Add to Cart</button>
                        @else
                            <button class="btn btn-danger" disabled>Out of Stock</button>
                        @endif
                        <a href="{{ route('product_wishlist_updater', ['id' => $product->id]) }}" class="default_btn small rounded second border-none">
                        @auth
                            <i class="las {{ $inWishlist ? 'la-minus-circle' : 'la-heart' }} me-2"></i> Wishlist</a>
                        @else
                            <i class="las la-heart"></i>
                        @endauth
                    </div>
                    <div class="share_icons footer_icon d-flex justify-content-center">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" target="_blank"><i class="lab la-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}" target="_blank"><i class="lab la-twitter"></i></a>
                        <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(Request::url()) }}" target="_blank"><i class="lab la-linkedin"></i></a>
                        <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(Request::url()) }}" target="_blank"><i class="lab la-pinterest"></i></a>
                        <a href="https://wa.me/send?text={{ urlencode(Request::url()) }}" target="_blank"><i class="lab la-whatsapp"></i></a>
                        <a href="mailto:?body={{ urlencode(Request::url()) }}" target="_blank"><i class="las la-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="product_view_tabs mt-4">
            <div class="pv_tab_buttons" class="spec_text">
                <div class="pbt_single_btn active" data-target=".description">Description</div>
                <div class="pbt_single_btn" data-target=".specifications">Specifications</div>
            </div>
            <div class="pb_tab_content description active">
                <div class="row">
                    <div class="col-lg-8">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
            <div class="pb_tab_content specifications">
                @if(!empty($specification))
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <table class="table">
                            <tbody>
                                @foreach($specification as $spec)
                                <tr>
                                    <td class="text-muted">{{ $spec['key'] }}</td>
                                    <td class="d-flex justify-content-end text-muted">{{ $spec['value'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@if($related_products->isNotEmpty())
<!-- new arrive -->
<section class="new_arrive section_padding_b">
    <div class="container">
        <div class="d-flex align-items-start justify-content-between">
            <h2 class="section_title_2">Related products</h2>
        </div>
        <div class="product_slider_2">
        @foreach($related_products as $pd)
        @php 
            $pd_images = json_decode($pd->images, true);
        @endphp
        @auth
        @php
        $wishlistIds = auth()->check() ? auth()->user()->wishlist->pluck('product_id')->toArray() : [];
        $inWishlist = in_array($pd->id, $wishlistIds);
        @endphp
        @endauth
            <div class="single_toparrival">
               <div class="single_new_arrive">
                  <div class="sna_img">
                      <a href="{{ route('product_view', ['slug' => $pd->slug]) }}">
                          <img loading="lazy" class="prd_img" src="{{ Storage::url($pd_images[0]) }}" />
                      </a>
                      @if($pd->quantity === 0)
                      <span class="tag">Stock Out</span>
                      @endif
                      <div class="prodcut_hovcont">
                          <a href="{{ route('product_wishlist_updater', ['id' => $pd->id]) }}" class="icon" tabindex="0">
                              @auth
                              <i class="las {{ $inWishlist ? 'la-minus-circle la-lg' : 'la-heart' }}"></i>
                              @else
                              <i class="las la-heart"></i>
                              @endauth
                          </a>
                      </div>
                  </div>
                  <div class="sna_content">
                      <a href="{{ route('product_view', ['slug' => $pd->slug]) }}">
                          <h6>{{ Str::limit($pd->title, 55) }}</h6>
                       </a>
                      <div class="ratprice mt-3">
                          <div class="price d-flex align-items-center">
                            @if($pd->regular_price)
                            <span class="prev_price ms-0">&#x9F3;{{ $pd->regular_price }}</span>
                            @endif
                            <span class="org_price ms-2">&#x9F3;{{ $pd->sale_price }}</span>
                            @if($pd->regular_price)
                            <div class="disc_tag ms-3">-{{ number_format((($pd->regular_price - $pd->sale_price) / $pd->regular_price) * 100, 0) }}%</div>
                            @endif
                          </div>
                      </div>
                      <div class="product_adcart">
                        @if($pd->quantity > 0)
                        <button type="button" class="default_btn add_to_cart_slider" 
                           data-id="{{ $pd->id }}" 
                           data-title="{{ $pd->title }}" 
                           data-slug="{{ $pd->slug }}" 
                           data-image="{{ Storage::url($pd_images[0]) }}" 
                           data-price="{{ $pd->sale_price }}" 
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
</section>
@endif
@endsection
@section("script")
<script>
$(document).ready(function() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let productId = $('.add_to_cart_btn').data('id');
    let productIndex = cart.findIndex(item => item.id === productId);

    if (productIndex !== -1 && cart !== null) {
        let quantity = cart[productIndex].quantity;
        $('#quantity_display').text(quantity);
        $('#quantity_field').val(quantity);
    }else{
        $('#quantity_display').text(1);
        $('#quantity_field').val(1);
    }

    $('#quantity_btn_minus').click(function() {
        let currentValue = parseInt($('#quantity_field').val());
        let maxValue = parseInt($('#quantity_field').attr('max'));
        if (currentValue > 1) {
            $('#quantity_field').val(currentValue - 1);
            $('#quantity_display').text(currentValue - 1);
            $('.add_to_cart_btn').removeAttr('data-quantity');
            $('.add_to_cart_btn').attr('data-quantity', currentValue - 1);
            if (productIndex !== -1 && cart !== null) {
                cart[productIndex].quantity = currentValue - 1;
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartView();
            }
        }
    });
    $('#quantity_btn_plus').click(function() {
        let currentValue = parseInt($('#quantity_field').val());
        let maxValue = parseInt($('#quantity_field').attr('max'));
        if (currentValue < maxValue) {
            $('#quantity_field').val(currentValue + 1);
            $('#quantity_display').text(currentValue + 1);
            $('.add_to_cart_btn').removeAttr('data-quantity');
            $('.add_to_cart_btn').attr('data-quantity', currentValue + 1);
            if (productIndex !== -1 && cart !== null) {
                cart[productIndex].quantity = currentValue + 1;
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartView();
            }
        }
    });

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
      $('.add_to_cart_slider').each(function() {
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

    $('.add_to_cart_slider').on('click', function() {
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

    $('.thumbnail').click(function() {
        $('#main_image').attr('src', $(this).attr('src'));
    });
});
</script>
@endsection