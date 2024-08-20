@extends("general_base")
@section("title") My Cart @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('product_cart') }}" class="active">My Cart</a>
	</div>
</div>
<!-- cart -->
<div class="cart_area section_padding_b">
	<div class="container">
		<div class="row">
			<div class="col-lg-9">
				<h4 class="shop_cart_title sopcart_ttl d-none d-lg-flex">
					<span>Product</span>
					<span>Quantity</span>
					<span>Total Price</span>
				</h4>
				<div class="shop_cart_wrap">
				</div>
			</div>
			<div class="col-lg-3 mt-4 mt-lg-0">
				<div class="cart_summary">
					<h4>Order Summary</h4>
					<div class="cartsum_text d-flex justify-content-between">
						<p class="text-semibold">Subtotal</p>
						<p class="text-semibold" id="page_sub_total">0</p>
					</div>
					<div class="cartsum_text d-flex justify-content-between">
						<p>Delivery</p>
						<p>&#x9F3;{{ $settings->delivery_charge_inside }}</p>
					</div>
					<div class="cartsum_text d-flex justify-content-between">
						<p>Tax</p>
						<p>&#x9F3;{{ $settings->tax }}</p>
					</div>
					<div class="cart_sum_total d-flex justify-content-between">
						<p>Total</p>
						<p id="page_total">0</p>
					</div>
					<div class="cart_sum_pros d-flex">
						<a href="{{ route('product_checkout') }}">Proccees to checkout</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section("script")
<script>
$(document).ready(function(){
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
        $('.cart_subtotal').html('&#x9F3;' + subtotal);

        $('.remove_cart').click(function() {
            let productId = $(this).data('id');
            removeFromCart(productId);
        });
    }

	function cartItems() {
		let cart = JSON.parse(localStorage.getItem('cart')) || [];
		let cartItemsContainer = $('.shop_cart_wrap');
		cartItemsContainer.empty();
		let subtotal = 0;
		cart.forEach(function(item) {
			let cartItemHtml = `
				<div class="single_shop_cart d-flex align-items-center flex-wrap" data-id="${item.id}">
					<div class="cart_img mb-4 mb-md-0">
						<img loading="lazy" src="${item.image}" class="rounded shadow-sm">
					</div>
					<div class="cart_cont">
						<a href="/product/${item.slug}">
							<h5>${item.title}</h5>
						</a>
						<p class="price">&#x9F3;${item.price}</p>
					</div>
					<div class="cart_qnty d-flex align-items-center ms-md-auto">
						<div class="cart_qnty_btn minus_btn">
							<i class="las la-minus"></i>
						</div>
						<div class="cart_count">${item.quantity}</div>
						<div class="cart_qnty_btn plus_btn">
							<i class="las la-plus"></i>
						</div>
					</div>
					<div class="cart_price ms-auto">
						<p>&#x9F3;<span class="item_total">${item.price * item.quantity}</span></p>
					</div>
					<div class="cart_remove ms-auto">
						<a href="javascript:void(0)" class="cart_remove_btn" data-id="${item.id}"><i class="icon-trash"></i></a>
					</div>
				</div>
			`;
			cartItemsContainer.append(cartItemHtml);
			subtotal += item.price * item.quantity;
		});
		$('#page_sub_total').html('&#x9F3;' + subtotal);
        $('#page_total').html('&#x9F3;' + (subtotal + parseInt('{{ $settings->delivery_charge_inside }}') + parseInt('{{ $settings->tax }}')));

		$('.minus_btn').click(function() {
			let cartItemElement = $(this).closest('.single_shop_cart');
			let productId = cartItemElement.data('id');
			updateCartItemQuantity(productId, -1);
		});

		$('.plus_btn').click(function() {
			let cartItemElement = $(this).closest('.single_shop_cart');
			let productId = cartItemElement.data('id');
			updateCartItemQuantity(productId, 1);
		});

		$('.cart_remove_btn').click(function() {
			let productId = $(this).data('id');
			removeFromCart(productId);
		});
	}

	function updateCartItemQuantity(productId, change) {
		let cart = JSON.parse(localStorage.getItem('cart')) || [];
		let productIndex = cart.findIndex(item => item.id === productId);
		if (productIndex !== -1) {
			let item = cart[productIndex];
			item.quantity += change;
			if (item.quantity < 1) {
				item.quantity = 1;
			}
			cart[productIndex] = item;
			localStorage.setItem('cart', JSON.stringify(cart));
			updateCartDisplay(productId, item.quantity, item.price * item.quantity);
			updateCartView();
			cartItems();
		}
	}

	function updateCartDisplay(productId, quantity, total) {
		let cartItemElement = $(`.single_shop_cart[data-id="${productId}"]`);
		cartItemElement.find('.cart_count').text(quantity);
		cartItemElement.find('.item_total').text(total);
	}

	function removeFromCart(productId) {
		let cart = JSON.parse(localStorage.getItem('cart')) || [];
		let updatedCart = cart.filter(item => item.id !== productId);
		localStorage.setItem('cart', JSON.stringify(updatedCart));
		cartItems();
		updateCartBadge();
        updateCartView();
	}

	cartItems();
});
</script>
@endsection