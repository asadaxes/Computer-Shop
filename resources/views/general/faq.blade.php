@extends("general_base")
@section("title") Frequently Asked Questions @endsection
@section("style")
<style>
.faq_style{
    list-style: outside;
}
</style>
@endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('faq') }}" class="active">FAQ</a>
	</div>
</div>
<!-- faq -->
<div class="section_padding_b">
<div class="container">
<h2 class="section_title_2 text-center text-dark mb-0">Frequently Asked Questions</h2>
<hr class="w-25 mx-auto mt-2 mb-5">
<div class="row">
<div class="col-12">
<ul class="list-group">
@forelse ($faqs as $faq)
<li class="list-group-item cursor_pointer" data-bs-toggle="collapse" data-bs-target="#faq_{{ $loop->iteration }}">
<h6 class="text-dark my-2">{{ $loop->iteration }}. {{ $faq->question }}</h6>
<ol class="collapse faq_style" id="faq_{{ $loop->iteration }}">
<li class="text-muted">{{ $faq->answer }}</li>
</ol>
</li>
@empty
<div class="text-muted text-center">no faqs found!</div>
@endforelse
</ul>
</div>
</div>
</div>
</div>
@endsection