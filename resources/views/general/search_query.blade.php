@extends("general_base")
@section("title") Products @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('search_query') }}" class="active">Products</a>
	</div>
</div>
<!-- page content -->
<div class="shop_wrap section_padding_b">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 position-relative">
                <div class="filter_box py-3 px-3 shadow_sm">
                    <div class="close_filter d-block d-lg-none"><i class="las la-times"></i></div>
                    <div class="shop_filter d-block d-sm-none">
                        <h4 class="filter_title">Sort by</h4>
                        <div class="sorting_filter mb-2">
                            <select class="nice_select" style="display: none;">
                                <option value="">Default sorting</option>
                                <option value="">Price low-high</option>
                                <option value="">Price high-low</option>
                            </select><div class="nice-select nice_select" tabindex="0"><span class="current">Default sorting</span><ul class="list"><li data-value="" class="option selected">Default sorting</li><li data-value="" class="option">Price low-high</li><li data-value="" class="option">Price high-low</li></ul></div>
                        </div>
                    </div>
                    <div class="shop_filter">
                        <h6 class="filter_title">Filter by Processors</h6>
                        <div class="filter_list">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cpu_selector" id="intel" value="intel">
                                <label class="form-check-label" for="intel">Intel</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cpu_selector" id="amd" value="amd">
                                <label class="form-check-label" for="amd">AMD</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cpu_selector" id="apple_silicon" value="apple_silicon">
                                <label class="form-check-label" for="apple_silicon">Apple Silicon</label>
                            </div>
                        </div>
                    </div>
                    <div class="shop_filter">
                        <h6 class="filter_title">Filter by RAM</h6>
                        <div class="filter_list">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ram_selector" id="2_gb" value="2GB">
                                <label class="form-check-label" for="2_gb">2 GB</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ram_selector" id="4_gb" value="4GB">
                                <label class="form-check-label" for="4_gb">4 GB</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ram_selector" id="8_gb" value="8GB">
                                <label class="form-check-label" for="8_gb">8 GB</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ram_selector" id="16_gb" value="16GB">
                                <label class="form-check-label" for="16_gb">16 GB</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ram_selector" id="32_gb" value="32GB">
                                <label class="form-check-label" for="32_gb">32 GB</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ram_selector" id="64_gb" value="64GB">
                                <label class="form-check-label" for="64_gb">64 GB</label>
                            </div>
                        </div>
                    </div>
                    <div class="shop_filter border-bottom-0 pb-0 mb-0">
                        <h6 class="filter_title">Brands</h6>
                        <div class="filter_list">
                            @forelse ($brands as $brand)
                            <a href="{{ route('search_query', ['search' => $brand->name]) }}" class="btn border mb-1">
                                <img src="{{ Storage::url($brand->logo) }}" class="img-fluid" width="50px">
                            </a>
                            @empty
                            <div class="d-flex align-items-center">
                                <span class="text-muted">no brands found!</span>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="shop_products">
                    <div class="row gy-4 mb-2">
                    @forelse ($products as $product)
                    @php 
                        $images = json_decode($product->images, true);
                    @endphp
                    @auth
                    @php
                    $wishlistIds = auth()->check() ? auth()->user()->wishlist->pluck('product_id')->toArray() : [];
                    $inWishlist = in_array($product->id, $wishlistIds);
                    @endphp
                    @endauth
                        <div class="col-md-4 col-sm-6">
                            <div class="single_new_arrive">
                                <div class="sna_img">
                                    <a href="{{ route('product_view', ['slug' => $product->slug]) }}">
                                        <img loading="lazy" class="prd_img" src="{{ Storage::url($images[0]) }}" />
                                    </a>
                                    @if($product->quantity === 0)
                                    <span class="tag">Stock Out</span>
                                    @endif
                                    <div class="prodcut_hovcont">
                                        <a href="{{ route('product_wishlist_updater', ['id' => $product->id]) }}" class="icon" tabindex="0">
                                            @auth
                                            <i class="las {{ $inWishlist ? 'la-minus-circle la-lg' : 'la-heart' }}"></i>
                                            @else
                                            <i class="las la-heart"></i>
                                            @endauth
                                        </a>
                                    </div>
                                </div>
                                <div class="sna_content">
                                    <a href="{{ route('product_view', ['slug' => $product->slug]) }}">
                                        <h6>{{ Str::limit($product->title, 70) }}</h6>
                                    </a>
                                    <div class="ratprice mt-3">
                                        <div class="price d-flex align-items-center">
                                            @if($product->regular_price)
                                            <span class="prev_price ms-0">&#x9F3;{{ $product->regular_price }}</span>
                                            @endif
                                            <span class="org_price ms-2">&#x9F3;{{ $product->sale_price }}</span>
                                            @if($product->regular_price)
                                            <div class="disc_tag ms-3">-{{ number_format((($product->regular_price - $product->sale_price) / $product->regular_price) * 100, 0) }}%</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product_adcart">
                                        @if($product->quantity > 0)
                                        <button type="button" class="default_btn add_to_cart_btn" 
                                           data-id="{{ $product->id }}" 
                                           data-title="{{ $product->title }}" 
                                           data-slug="{{ $product->slug }}" 
                                           data-image="{{ Storage::url($images[0]) }}" 
                                           data-price="{{ $product->sale_price }}" 
                                           data-quantity="1"><i class="icon-cart me-2"></i> Add to Cart</button>
                                        @else
                                           <button class="btn btn-danger" disabled>Out of Stock</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h3 class="text-muted text-center">no results found!</h3>
                    @endforelse
                    </div>
                    <div class="col-12 d-flex justify-content-between align-items-baseline py-4">
                        <small class="text-dark">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results</small>
                        {{ $products->links("partial.pagination") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("script")
<script>
document.addEventListener("DOMContentLoaded", function() {
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

   let selectedRadio = getSearchBarUrl();
    if (selectedRadio) {
        $(`input[name="cpu_selector"][value="${selectedRadio}"]`).prop('checked', true);
    }
   $('input[name="cpu_selector"]').change(function() {
        let selectedRadio = $(this).val();
        let redirectUrl = "{{ route('search_query', ['search' => '']) }}" + selectedRadio;
        window.location.href = redirectUrl;
    });
    if (selectedRadio) {
        $(`input[name="ram_selector"][value="${selectedRadio}"]`).prop('checked', true);
    }
   $('input[name="ram_selector"]').change(function() {
        let selectedRadio = $(this).val();
        let redirectUrl = "{{ route('search_query', ['search' => '']) }}" + selectedRadio;
        window.location.href = redirectUrl;
    });
});
</script>
@endsection