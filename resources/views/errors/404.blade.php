@extends("general_base")
@section("title") Page Not Found @endsection
@section("content")
<div class="section_padding_b mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-9">
                <div class="page_nfwrap">
                    <div class="page_nfimg">
                        <img loading="lazy" src="{{ asset('assets/404.svg') }}" class="w-100">
                    </div>
                    <div class="page_nfcont text-center mt-5">
                        <h4 class="mb-4">THE PAGE YOU'VE REQUESTED IS NOT AVAILABLE</h4>
                        <a href="{{ route('home') }}" class="default_btn small rounded">back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection