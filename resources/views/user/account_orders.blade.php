@extends("general_base")
@section("title") My Orders History @endsection
@section("style")
<style>
img.product_list_img{
    width: 25px;
}
</style>
@endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('user_account') }}">My Account</a>
		<a href="{{ route('user_account_orders') }}" class="active">My Orders History</a>
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
				<table class="table table-bordered table-hover table-responsive text-center">
					<thead>
						<tr>
							<th class="text-muted">Order ID</th>
							<th class="text-muted">Products</th>
							<th class="text-muted">Quantity</th>
							<th class="text-muted">Amount</th>
							<th class="text-muted">Shipping & Delivery</th>
							<th class="text-muted">Progress</th>
							<th class="text-muted">Date</th>
						</tr>
					</thead>
					<tbody>
						@php
							$orderQuantities = [];
							foreach ($orders as $order) {
								if (!isset($orderQuantities[$order->order_id])) {
									$orderQuantities[$order->order_id] = 0;
								}
								$orderQuantities[$order->order_id] += $order->quantity;
							}
						@endphp
						@forelse ($orders as $index => $order)
						@if ($index == 0 || $order->order_id != $orders[$index - 1]->order_id)
							<tr>
								<td>{{ $order->order_id }}</td>
								<td class="text-left">
									<div class="d-flex flex-column align-items-start">
										@foreach ($orders->where('order_id', $order->order_id) as $item)
											<?php $images = json_decode($item->product->images, true); ?>
											<a href="{{ route('product_view', ['slug' => $item->product->slug]) }}" class="text-dark">
												<img src="{{ Storage::url($images[0]) }}" class="img-fluid rounded product_list_img mr-1">
												<small>{{ Str::limit($item->product->title, 25) }}</small>
											</a>
										@endforeach
									</div>
								</td>
								<td>{{ $orderQuantities[$order->order_id] }}</td>
								<td>&#x9F3;{{ $order->amount }}</td>
								<td>
									<button class="btn btn-light btn-sm border" data-bs-toggle="modal" data-bs-target="#shipping_and_delivert_view" data-snd="{{ $order->shipping_address }}" data-dm="{{ $order->delivery_method }}">view</button>
								</td>
								<td>{{ ucfirst($order->deliver_status) }}</td>
								<td>
									<div class="d-flex flex-column">
										<small>{{ \Carbon\Carbon::parse($order->issued_at)->format('h:i A') }}</small>
										<small>{{ \Carbon\Carbon::parse($order->issued_at)->format('M d, Y') }}</small>
									</div>
								</td>
							</tr>
						@endif
					@empty
						<tr>
							<td colspan="7" class="text-center text-muted">No orders made yet!</td>
						</tr>
					@endforelse
					</tbody>
				</table>
			</div>
        </div>
    </div>
</div>

<div class="modal fade" id="shipping_and_delivert_view" tabindex="-1" >
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Shipping & Delivery Address</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body shipping_and_delivert_modal_body">
      </div>
    </div>
  </div>
</div>
@endsection
@section("script")
<script>
$('#shipping_and_delivert_view').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let snd = button.data('snd');
    let dm = button.data('dm');
    let delivery_method = dm === 'pay_with_ssl' ? 'Digital Payment' : 'Cash on Delivery';
    let modal = $(this);
    modal.find('.shipping_and_delivert_modal_body').html(`
        <div><span class="fw-bold text-muted">Payment Option: </span>${delivery_method}</div>
        <table class="table mt-2 mb-0">
            <tbody>
                <tr>
                    <td class="text-dark">Full Name</td>
                    <td>:</td>
                    <td>${snd.first_name} ${snd.last_name}</td>
                </tr>
                <tr>
                    <td class="text-dark">Email</td>
                    <td>:</td>
                    <td>${snd.email}</td>
                </tr>
                <tr>
                    <td class="text-dark">Phone</td>
                    <td>:</td>
                    <td>${snd.phone}</td>
                </tr>
                <tr>
                    <td class="text-dark">Address</td>
                    <td>:</td>
                    <td>${snd.address}</td>
                </tr>
                <tr>
                    <td class="text-dark">City</td>
                    <td>:</td>
                    <td>${snd.city}</td>
                </tr>
                <tr>
                    <td class="text-dark">Country</td>
                    <td>:</td>
                    <td>${snd.country}</td>
                </tr>
                <tr>
                    <td class="text-dark">Zip Code</td>
                    <td>:</td>
                    <td>${snd.zip_code}</td>
                </tr>
            </tbody>
         </table>
    `);
});
</script>
@endsection