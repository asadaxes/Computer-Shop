@extends("general_base")
@section("title") Checkout @endsection
@section("style")
<style>
#flag_icon{
    width: 20px;
}
.country_list_item:hover{
    background-color: #f79f1f;
    color: #ffffff;
    cursor: pointer;
}
img.digital_payment_icons{
	width: 300px;
}
</style>
@endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('product_cart') }}">My Cart</a>
		<a href="{{ route('product_checkout') }}" class="active">Checkout</a>
	</div>
</div>
<!-- checkout -->
<div class="cart_area section_padding_b">
	<div class="container">
		<form action="{{ route('product_checkout_handler') }}" method="POST">
		@csrf
		<div class="row">
			<div class="col-xl-8 col-lg-7 col-md-6">
				<h4 class="shop_cart_title mb-4 ps-3">Shipping details</h4>
				<div class="billing_form">
					<div class="row">
						<div class="col-lg-6">
							<div class="single_billing_inp">
								<label for="first_name">First Name <span>*</span></label>
								<input type="text" name="first_name" id="first_name" value="{{ auth()->user()->first_name }}" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="single_billing_inp">
								<label for="last_name">Last Name <span>*</span></label>
								<input type="text" name="last_name" id="last_name" value="{{ auth()->user()->last_name }}" required>
							</div>
						</div>
						<div class="col-12">
							<div class="single_billing_inp">
								<label for="company_name">Company Name <small class="text-muted">(optional)</small></label>
								<input type="text" name="company_name" id="company_name" value="{{ auth()->user()->company_name }}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="single_billing_inp">
								<label for="phone_number">Phone Number <span>*</span></label>
								<input type="text" name="phone" id="phone_number" value="{{ auth()->user()->phone }}" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="single_billing_inp">
								<label for="email_addr">Email Address <span>*</span></label>
								<input type="email" name="email" id="email_addr" value="{{ auth()->user()->email }}" required>
							</div>
						</div>
						<div class="col-12">
							<div class="single_billing_inp">
								<label for="street_addr">Street Address <span>*</span></label>
								<input type="text" name="address" id="street_addr" value="{{ auth()->user()->address }}" required>
							</div>
						</div>
						<div class="col-12">
							<div class="single_billing_inp">
								<label for="country_field">Country/Region <span>*</span></label>
								<div class="d-flex align-items-baseline">
									<input type="text" name="country" id="country_field" value="{{ auth()->user()->country }}" required>
									<button type="button" class="btn bg-light text-center border p-2" data-bs-toggle="modal" data-bs-target="#country_selector_modal"><i class="las la-flag text-dark p-0"></i></button>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="single_billing_inp">
								<label for="city">City <span>*</span></label>
								<select name="city" id="city" class="form-select" required>
									<option value="default" selected>Select a city</option>
									<option value="Dhaka">Dhaka</option>
									<option value="Chittagong">Chittagong</option>
									<option value="Khulna">Khulna</option>
									<option value="Rajshahi">Rajshahi</option>
									<option value="Comilla">Comilla</option>
									<option value="Mymensingh">Mymensingh</option>
									<option value="Barisal">Barisal</option>
									<option value="Sylhet">Sylhet</option>
									<option value="Rangpur">Rangpur</option>
									<option value="Cox's Bazar">Cox's Bazar</option>
									<option value="Jessore">Jessore</option>
									<option value="Narayanganj">Narayanganj</option>
									<option value="Dinajpur">Dinajpur</option>
									<option value="Pabna">Pabna</option>
									<option value="Tangail">Tangail</option>
									<option value="Bogra">Bogra</option>
									<option value="Narsingdi">Narsingdi</option>
									<option value="Jhenaidah">Jhenaidah</option>
									<option value="Faridpur">Faridpur</option>
									<option value="Jamalpur">Jamalpur</option>
									<option value="Saidpur">Saidpur</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="single_billing_inp">
								<label for="zip_code">Zip Code <span>*</span></label>
								<input type="text" name="zip_code" id="zip_code" value="{{ auth()->user()->zip_code }}" required>
							</div>
						</div>
						<input type="hidden" name="products" id="delivery_products">
						<input type="hidden" name="coupon_code" id="coupon_code_data">
						<div class="col-12 mt-4">
							<div class="card card-body">
								<h4 class="text-muted mb-2">Have any coupon code?</h4>
								<div class="cart_sum_coupon mb-0">
									<input type="text" id="coupon_code_field" placeholder="Enter coupon">
									<button type="submit" id="coupon_code_btn">Apply</button>
								</div>
								<div id="coupon_message"></div>
							</div>
						</div>
					</div>					
				</div>
			</div>
			<div class="col-xl-4 col-lg-5 col-md-6">
				<h4 class="shop_cart_title ps-3">Your order</h4>
				<div class="checkout_order mt-4">
					<h4>product</h4>
					<div id="products_list"></div>
					<div class="single_check_order subs">
						<div class="checkorder_cont subtotal-h">
							<h5>Subtotal</h5>
						</div>
						<p class="checkorder_price" id="checkout_subtotal"></p>
					</div>
					<div class="single_check_order subs">
						<div class="checkorder_cont subtotal-h">
							<h5>Delivery Charge</h5>
						</div>
						<p class="checkorder_price" id="checkout_deliver_charge">&#x9F3;{{ $settings->delivery_charge_inside }}</p>
					</div>
					<div class="single_check_order subs">
						<div class="checkorder_cont subtotal-h">
							<h5>Tax</h5>
						</div>
						<p class="checkorder_price" id="checkout_tax">&#x9F3;{{ $settings->tax }}</p>
					</div>
					<div class="single_check_order total">
						<div class="checkorder_cont">
							<h5>Total</h5>
						</div>
						<p class="checkorder_price" id="checkout_total"></p>
					</div>
					<div class="d-flex flex-column mb-2">
						<span class="text-dark mb-2">Choose Payment Method <i class="las la-level-down-alt"></i></span>
						<div class="form-check d-flex justify-content-start align-items-center">
							<input class="form-check-input" type="radio" name="payment_method" id="digital_payment" value="pay_with_ssl">
							<label class="form-check-label cursor_pointer" for="digital_payment">
							  <img src="{{ asset('assets/payment_methods_checkout.png') }}" class="img-fluid digital_payment_icons">
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="payment_method" id="cash_on_delivery" value="cash_on_delivery">
							<label class="form-check-label cursor_pointer" for="cash_on_delivery">Cash on Delivery</label>
						</div>
					</div>
					<div class="checkorder_btn">
						<button type="submit" class="default_btn rounded w-100">Confirm & Place Order</button>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<div class="modal fade" id="country_selector_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Select Country</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-2">
        <input type="text" id="country_search" class="form-control mb-2" placeholder="Search for your country">
        <ul class="list-group" id="country_list">
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
@section("script")
<script>
$(document).ready(function(){
	let delivery_charge = parseInt("{{ $settings->delivery_charge_inside }}");
	let tax = parseInt("{{ $settings->tax }}");
	let cart = JSON.parse(localStorage.getItem('cart')) || [];
	let cartItemsContainer = $('#products_list');
	cartItemsContainer.empty();
	let checkout_subtotal = 0;
	cart.forEach(function(item) {
		let cartItemHtml = `
			<div class="single_check_order">
				<div class="checkorder_cont">
					<h5><a href="/product/${item.slug}">${item.title.substring(0, 25) + '...'}</a></h5>
				</div>
				<p class="checkorder_qnty">x${item.quantity}</p>
				<p class="checkorder_price">&#x9F3;${item.price * item.quantity}</p>
			</div>
			`;
			cartItemsContainer.append(cartItemHtml);
			checkout_subtotal += item.price * item.quantity;
	});
	$('#checkout_subtotal').html('&#x9F3;' + checkout_subtotal);
	$('#checkout_total').html('&#x9F3;' + (checkout_subtotal + delivery_charge + tax));

	const countryData = {
		"af": "Afghanistan", "al": "Albania", "dz": "Algeria", "as": "American Samoa", "ad": "Andorra", "ao": "Angola", "ai": "Anguilla", "aq": "Antarctica", "ag": "Antigua and Barbuda", "ar": "Argentina", "am": "Armenia", "aw": "Aruba", "au": "Australia", "at": "Austria", "az": "Azerbaijan", "bs": "Bahamas", "bh": "Bahrain", "bd": "Bangladesh", "bb": "Barbados", "by": "Belarus", "be": "Belgium", "bz": "Belize", "bj": "Benin", "bm": "Bermuda", "bt": "Bhutan", "bo": "Bolivia", "bq": "Bonaire, Sint Eustatius and Saba", "ba": "Bosnia and Herzegovina", "bw": "Botswana", "bv": "Bouvet Island", "br": "Brazil", "io": "British Indian Ocean Territory", "bn": "Brunei Darussalam", "bg": "Bulgaria", "bf": "Burkina Faso", "bi": "Burundi", "kh": "Cambodia", "cm": "Cameroon", "ca": "Canada", "cv": "Cabo Verde", "ky": "Cayman Islands", "cf": "Central African Republic", "td": "Chad", "cl": "Chile", "cn": "China", "cx": "Christmas Island", "cc": "Cocos (Keeling) Islands", "co": "Colombia", "km": "Comoros", "cg": "Congo", "cd": "Congo, Democratic Republic of the", "ck": "Cook Islands", "cr": "Costa Rica", "hr": "Croatia", "cu": "Cuba", "cw": "Curaçao", "cy": "Cyprus", "cz": "Czech Republic", "dk": "Denmark", "dj": "Djibouti", "dm": "Dominica", "do": "Dominican Republic", "ec": "Ecuador", "eg": "Egypt", "sv": "El Salvador", "gq": "Equatorial Guinea", "er": "Eritrea", "ee": "Estonia", "et": "Ethiopia", "eu": "European Union", "fk": "Falkland Islands (Malvinas)", "fo": "Faroe Islands", "fj": "Fiji", "fi": "Finland", "fr": "France", "gf": "French Guiana", "pf": "French Polynesia", "tf": "French Southern Territories", "ga": "Gabon", "gm": "Gambia", "ge": "Georgia", "de": "Germany", "gh": "Ghana", "gi": "Gibraltar", "gr": "Greece", "gl": "Greenland", "gd": "Grenada", "gp": "Guadeloupe", "gu": "Guam", "gt": "Guatemala", "gg": "Guernsey", "gn": "Guinea", "gw": "Guinea-Bissau", "gy": "Guyana", "ht": "Haiti", "hm": "Heard Island and McDonald Islands", "va": "Holy See (Vatican City State)", "hn": "Honduras", "hk": "Hong Kong", "hu": "Hungary", "is": "Iceland", "in": "India", "id": "Indonesia", "ir": "Iran, Islamic Republic of", "iq": "Iraq", "ie": "Ireland", "il": "Israel (Palestinian Territory)", "im": "Isle of Man", "it": "Italy", "jm": "Jamaica", "jp": "Japan", "je": "Jersey", "jo": "Jordan", "kz": "Kazakhstan", "ke": "Kenya", "ki": "Kiribati", "kp": "Korea, Democratic People's Republic of", "kr": "Korea, Republic of", "xk": "Kosovo", "kw": "Kuwait", "kg": "Kyrgyzstan", "la": "Lao People's Democratic Republic", "lv": "Latvia", "lb": "Lebanon", "ls": "Lesotho", "lr": "Liberia", "ly": "Libya", "li": "Liechtenstein", "lt": "Lithuania", "lu": "Luxembourg", "mo": "Macao", "mg": "Madagascar", "mw": "Malawi", "my": "Malaysia", "mv": "Maldives", "ml": "Mali", "mt": "Malta", "mh": "Marshall Islands", "mq": "Martinique", "mr": "Mauritania", "mu": "Mauritius", "yt": "Mayotte", "mx": "Mexico", "fm": "Micronesia, Federated States of", "md": "Moldova, Republic of", "mc": "Monaco", "mn": "Mongolia", "me": "Montenegro", "ms": "Montserrat", "ma": "Morocco", "mz": "Mozambique", "mm": "Myanmar", "na": "Namibia", "nr": "Nauru", "np": "Nepal", "nl": "Netherlands", "nc": "New Caledonia", "nz": "New Zealand", "ni": "Nicaragua", "ne": "Niger", "ng": "Nigeria", "nu": "Niue", "nf": "Norfolk Island", "mp": "Northern Mariana Islands", "no": "Norway", "om": "Oman", "pk": "Pakistan", "pw": "Palau", "ps": "Palestine", "pa": "Panama", "pg": "Papua New Guinea", "py": "Paraguay", "pe": "Peru", "ph": "Philippines", "pn": "Pitcairn", "pl": "Poland", "pt": "Portugal", "pr": "Puerto Rico", "qa": "Qatar", "re": "Réunion", "ro": "Romania", "ru": "Russian Federation", "rw": "Rwanda", "sh": "Saint Helena, Ascension and Tristan da Cunha", "kn": "Saint Kitts and Nevis", "lc": "Saint Lucia", "mf": "Saint Martin (French part)", "pm": "Saint Pierre and Miquelon", "vc": "Saint Vincent and the Grenadines", "ws": "Samoa", "sm": "San Marino", "st": "Sao Tome and Principe", "sa": "Saudi Arabia", "sn": "Senegal", "rs": "Serbia", "sc": "Seychelles", "sl": "Sierra Leone", "sg": "Singapore", "sx": "Sint Maarten (Dutch part)", "sk": "Slovakia", "si": "Slovenia", "sb": "Solomon Islands", "so": "Somalia", "za": "South Africa", "gs": "South Georgia and the South Sandwich Islands", "ss": "South Sudan", "es": "Spain", "lk": "Sri Lanka", "sd": "Sudan", "sr": "Suriname", "sj": "Svalbard and Jan Mayen", "se": "Sweden", "ch": "Switzerland", "sy": "Syrian Arab Republic", "tw": "Taiwan, Province of China", "tj": "Tajikistan", "tz": "Tanzania, United Republic of", "th": "Thailand", "tl": "Timor-Leste", "tg": "Togo", "tk": "Tokelau", "to": "Tonga", "tt": "Trinidad and Tobago", "tn": "Tunisia", "tr": "Turkiye", "tm": "Turkmenistan", "tc": "Turks and Caicos Islands", "tv": "Tuvalu", "ug": "Uganda", "ua": "Ukraine", "ae": "United Arab Emirates", "gb": "United Kingdom", "us": "United States", "um": "United States Minor Outlying Islands", "un": "United Nations", "uy": "Uruguay", "uz": "Uzbekistan", "vu": "Vanuatu", "ve": "Venezuela, Bolivarian Republic of", "vn": "Viet Nam", "vg": "Virgin Islands, British", "vi": "Virgin Islands, U.S.", "wf": "Wallis and Futuna", "eh": "Western Sahara", "ye": "Yemen", "zm": "Zambia", "zw": "Zimbabwe"
	};
	function populateCountryList() {
	const modalBody = document.querySelector("#country_selector_modal .modal-body");
	const searchInput = modalBody.querySelector("#country_search");
	const countryList = modalBody.querySelector("#country_list");

	searchInput.addEventListener("input", function () {
		const searchTerm = searchInput.value.toLowerCase();
		const matchedCountries = Object.entries(countryData)
		.filter(([code, name]) => name.toLowerCase().includes(searchTerm))
		.slice(0, 5);

		renderCountryList(matchedCountries);
	});

	renderCountryList(Object.entries(countryData).slice(0, 5));
	}
	function renderCountryList(countryListData) {
	const listContainer = document.querySelector("#country_list");
	listContainer.innerHTML = "";

	for (const [countryCode, countryName] of countryListData) {
		const listItem = document.createElement("li");
		listItem.classList.add("list-group-item");
		listItem.classList.add("country_list_item");
		listItem.innerHTML = `<img src="{{ asset('flags') }}/${countryCode}.svg" id="flag_icon"> ${countryName}`;
		listItem.addEventListener('click', function () {
		document.getElementById('country_field').value = countryName;
		$('#country_selector_modal').modal('hide');
		});
		listContainer.appendChild(listItem);
	}
	}
	$('#country_selector_modal').on('shown.bs.modal', function () {
	populateCountryList();
	$("#country_search").focus();
	});


	let cartData = JSON.parse(localStorage.getItem('cart')) || [];
    let cartDataString = JSON.stringify(cartData);
    $('#delivery_products').val(cartDataString);

	let taxValue = parseInt("{{ $settings->tax }}");
    let deliveryChargeDhaka = parseInt("{{ $settings->delivery_charge_inside }}");
    let deliveryChargeOutside = parseInt("{{ $settings->delivery_charge_outside }}");

	function updateDeliveryCharge(selectedCity) {
        let deliveryChargeValue = 0;
        if(selectedCity === 'Dhaka'){
            deliveryChargeValue = deliveryChargeDhaka;
        }else if(selectedCity === 'default'){
            deliveryChargeValue = 0;
        }else{
            deliveryChargeValue = deliveryChargeOutside;
        }
        $('#checkout_deliver_charge').html('&#x9F3;' + deliveryChargeValue);
        return deliveryChargeValue;
    }
    
    $('#city').change(function() {
        let selectedCity = $(this).val();
        let deliveryChargeValue = updateDeliveryCharge(selectedCity);
        calculateTotalCost(deliveryChargeValue);
		if($('#coupon_code_data').val() !== ''){
			coupon_checker();
		}
    });

    function calculateTotalCost(deliveryChargeValue) {
        let subtotalValue = cartData.reduce((total, product) => total + (product.price * product.quantity), 0);
        $('#checkout_subtotal').html('&#x9F3;' + subtotalValue);
        let totalCostValue = subtotalValue + taxValue + deliveryChargeValue;
        $('#checkout_total').html('&#x9F3;' + totalCostValue);
    }

    let selectedCity = $('#city').val();
    let initialDeliveryCharge = updateDeliveryCharge(selectedCity);
    calculateTotalCost(initialDeliveryCharge);

	$('#coupon_code_btn').on('click', function(event) {
		event.preventDefault();
		coupon_checker();
	});

	function coupon_checker(){
		let couponCode = $('#coupon_code_field').val();
		let token = '{{ csrf_token() }}';
		$.ajax({
			url: "{{ route('product_coupon_checker') }}",
			method: "POST",
			data: {
				_token: token,
				coupon_code: couponCode
			},
			success: function(response) {
				if(response.valid) {
					$('#coupon_message').html(`<small class="fw-bold text-success">${response.message}</small>`);
					$('#coupon_code_data').val(response.code);
					let c_delivery_charges = 0;
					if($('#city').val() === 'Dhaka'){
						c_delivery_charges = deliveryChargeDhaka;
					}else{
						c_delivery_charges = deliveryChargeOutside;
					}
					let total = checkout_subtotal + c_delivery_charges + tax;
					if (response.type === 'percentage') {
						let discountAmount = (parseInt(response.value) / 100) * total;
						total -= discountAmount;
					} else if (response.type === 'fixed') {
						total -= parseInt(response.value);
					}
					$('#checkout_total').html('৳' + Math.floor(total));
				} else {
					$('#coupon_message').html(`<small class="fw-bold text-danger">${response.message}</small>`);
					$('#coupon_code_data').val('');
				}
			},
			error: function(xhr) {
				$('#coupon_message').html(`<small class="fw-bold text-danger">An error occurred. Please try again.</small>`);
				$('#coupon_code_data').val('');
			}
		});
	}
});
</script>
@endsection