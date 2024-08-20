@extends("general_base")
@section("title") Track My Order @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('track_order') }}">Track My Order</a>
	</div>
</div>
<!-- track order -->
<div class="track_orders section_padding_b">
    <div class="container">
        <div class="padding_default shadow_sm">
            <h2 class="title_2 mb-4">Order Tracking</h2>
            <form action="{{ route('track_order') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-lg-5">
                        <div class="single_billing_inp">
                            <label for="order_id">Order ID <span>*</span></label>
                            <input type="text" name="order_id" id="order_id" placeholder="#xxxxxxxxxxxxx" value="{{ isset($order) ? $order->order_id : '' }}" required>
                        </div>
                    </div>
                    <div class="col-12 mt-1">
                        <button type="submit" class="default_btn xs_btn rounded px-4">track order</button>
                    </div>
                </div>
            </form>

            @if(isset($order))
            <div class="mt-4 pt-2 track_status">
                <h4 class="title_3 text-uppercase">{{ ucfirst($order->deliver_status) }}</h4>
                <div class="track_path">
                    @php
                        $statuses = ['placed', 'preparing', 'shipping', 'delivered'];
                        $currentStatusIndex = array_search($order->deliver_status, $statuses);
                    @endphp
        
                    @foreach($statuses as $index => $status)
                        <div class="single_track {{ $index > $currentStatusIndex ? 'pending' : '' }}">
                            <h5 class="text_lg mb-0">{{ $index + 1 }}. {{ ucfirst($status) }}</h5>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        </div>
    </div>
</div>
@endsection