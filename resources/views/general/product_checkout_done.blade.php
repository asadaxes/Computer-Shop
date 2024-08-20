@extends("general_base")
@section("title") Successfull Checkout @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('product_cart') }}">My Cart</a>
		<a href="{{ route('product_checkout') }}">Checkout</a>
		<a href="" class="active">Order complete</a>
	</div>
</div>
<!-- checkout -->
<div class="cart_area section_padding_b">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="row">
					<div class="col-lg-8 mx-auto">
						<div class="order_complete">
							<div class="complete_icon">
								<i class="las la-check-circle la-4x text-success"></i>
							</div>
							<div class="order_complete_content">
								<h4>Your order is completed!</h4>
								<p>Thank you for your order! Your order is being processed and will be completed within 3-6 hours. You will receive an email confirmation when your order is completed.</p>
								<div class="order_complete_btn">
									<a href="{{ route('home') }}" class="default_btn rounded">continue shopping</a>
								</div>
								<div class="order_complete_btn mt-3">
									<a href="{{ route('track_order') }}"><i class="las la-map-marked-alt"></i> Track Your Order</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection