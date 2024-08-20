@extends("general_base")
@section("title") My Wishlist @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('user_account') }}">My Account</a>
		<a href="{{ route('user_account_wishlist') }}" class="active">My Wishlist</a>
	</div>
</div>
<!-- account -->
<div class="my_account_wrap section_padding_b">
	<div class="container">
		<div class="row">
			<!--  account sidebar  -->
			@include('partial.account_sidebar')
			<!-- account content -->
			<div class="col-lg-9">
				<div class="shop_cart_wrap wishlist">
					@forelse ($wishlist as $wl)
					@php
						$images = json_decode($wl->product->images, true);
					@endphp
						<div class="single_shop_cart d-flex align-items-center flex-wrap mt-0">
							<div class="cart_img mb-4 mb-md-0">
								<a href="{{ route('product_view', ['slug' => $wl->product->slug]) }}"><img loading="lazy" src="{{ Storage::url($images[0]) }}"></a>
							</div>
							<div class="cart_cont">
								<a href="{{ route('product_view', ['slug' => $wl->product->slug]) }}"><h5>{{ $wl->product->title }}</h5></a>
								<p class="instock mb-0">Availability: 
									@if($wl->product->quantity > 0)
										<span class="text-success">In Stock</span>
									@else
										<span class="text-danger">Out of Stock</span>
									@endif
								</p>
							</div>
							<div class="cart_price ms-md-auto ms-0">
								<p>&#x9F3;{{ $wl->product->sale_price }}</p>
							</div>
							<div class="cart_remove ms-auto align-self-end align-self-md-center">
								<a href="{{ route('product_wishlist_remover', ['id' => $wl->id]) }}"><i class="icon-trash text-danger"></i></a>
							</div>
						</div>
					@empty
						<h5 class="text-muted text-center">Your wishlist is empty!</h5>
					@endforelse
				</div>
				<div class="d-flex justify-content-between align-items-baseline py-4">
					<small class="text-dark">Showing {{ $wishlist->firstItem() }} to {{ $wishlist->lastItem() }} of {{ $wishlist->total() }} results</small>
					{{ $wishlist->links("partial.pagination") }}
				</div>
			</div>
        </div>
    </div>
</div>
@endsection