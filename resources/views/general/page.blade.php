@extends("general_base")
@section("title") {{ $page->name }} @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
    <div class="breadcrumbs">
        <a href="{{ route('home') }}"><i class="las la-home"></i></a>
        <a href="{{ route('page_details', ['slug' => $page->slug]) }}" class="active">{{ $page->name }}</a>
    </div>
</div>
<!-- page content -->
<div class="section_padding_b">
    <div class="container">
        <h2 class="section_title_2 mb-3 text-center">{{ $page->name }}</h2>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="privacy_content">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection