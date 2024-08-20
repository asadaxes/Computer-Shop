@extends("general_base")
@section("title") Best Deals @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('best_deals') }}" class="active">Best Deals</a>
	</div>
</div>
<!-- brands list -->
<div class="section_padding_b">
<div class="container">
<h2 class="section_title_2 text-center mb-0">Best Deals</h2>
<hr class="w-25 mx-auto mt-2 mb-5">
<div class="row">
    @forelse ($products as $pd)
    @php 
        $images = json_decode($pd->product->images, true);
        $wishlistIds = auth()->user()->wishlist->pluck('product_id')->toArray();
        $inWishlist = in_array($pd->product->id, $wishlistIds);
    @endphp
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="single_new_arrive">
                <div class="sna_img">
                    <a href="{{ route('product_view', ['slug' => $pd->product->slug]) }}">
                        <img loading="lazy" class="prd_img" src="{{ Storage::url($images[0]) }}" />
                    </a>
                    @if($pd->product->quantity === 0)
                    <span class="tag">Stock Out</span>
                    @endif
                    <div class="prodcut_hovcont">
                        <a href="{{ route('product_wishlist_updater', ['id' => $pd->product->id]) }}" class="icon" tabindex="0">
                            <i class="las {{ $inWishlist ? 'la-minus-circle la-lg' : 'la-heart' }}"></i>
                        </a>
                    </div>
                </div>
                <div class="sna_content">
                    <a href="{{ route('product_view', ['slug' => $pd->product->slug]) }}">
                        <h6>{{ Str::limit($pd->product->title, 70) }}</h6>
                    </a>
                    <div class="ratprice mt-3">
                        <div class="price d-flex align-items-center">
                            @if($pd->product->regular_price)
                            <span class="prev_price ms-0">&#x9F3;{{ $pd->product->regular_price }}</span>
                            @endif
                            <span class="org_price ms-2">&#x9F3;{{ $pd->product->sale_price }}</span>
                            @if($pd->product->regular_price)
                            <div class="disc_tag ms-3">-{{ number_format((($pd->product->regular_price - $pd->product->sale_price) / $pd->product->regular_price) * 100, 0) }}%</div>
                            @endif
                        </div>
                    </div>
                    <div class="product_adcart">
                        @if($pd->product->quantity > 0)
                        <button type="button" class="default_btn add_to_cart_btn" 
                           data-id="{{ $pd->product->id }}" 
                           data-title="{{ $pd->product->title }}" 
                           data-slug="{{ $pd->product->slug }}" 
                           data-image="{{ Storage::url($images[0]) }}" 
                           data-price="{{ $pd->product->sale_price }}" 
                           data-quantity="1"><i class="icon-cart me-2"></i> Add to Cart</button>
                        @else
                           <button class="btn btn-danger" disabled>Out of Stock</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
    <div class="col-12 text-center">
        <span class="text-muted">no products found!</span>
    </div>
@endforelse
<div class="col-12 d-flex justify-content-between align-items-baseline py-4">
    <small class="text-dark">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results</small>
    {{ $products->links("partial.pagination") }}
</div>
</div>
</div>
</div>
@endsection