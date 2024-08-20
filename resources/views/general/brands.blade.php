@extends("general_base")
@section("title") Brands @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('brands_list') }}" class="active">Brands</a>
	</div>
</div>
<!-- brands list -->
<div class="section_padding_b">
<div class="container">
<div class="row d-flex align-items-center">
@forelse ($brands as $brand)
<div class="col mb-2">
    <a href="{{ route('search_query', ['search' => $brand->name]) }}" class="btn">
        <img src="{{ Storage::url($brand->logo) }}" width="100px">
    </a>
</div>
@empty
    <div class="col-12 text-center">
        <span class="text-muted">no brands found!</span>
    </div>
@endforelse
</div>
</div>
</div>
@endsection