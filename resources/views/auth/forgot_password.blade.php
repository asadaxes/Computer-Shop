@extends("general_base")
@section("title") Forgot Password @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
  <div class="breadcrumbs">
    <a href="{{ route('home') }}"><i class="las la-home"></i></a>
    <a href="{{ route('password.request') }}" class="active">Forgot Password</a>
  </div>
</div>
<!-- forgot password -->
<div class="section_padding mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7">
                <div class="padding_default shadow_sm">
                    <h2 class="title_2">reset password</h2>
                    <p class="text_md mb-4">Please enter your email address below to receive a link.</p>
                    @if(session('status'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="single_billing_inp">
                            <label>Email Address <span>*</span></label>
                            <input type="email" name="email" placeholder="example@gmail.com" required>
                        </div>
                        <div class="col-12 mb-2">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="default_btn rounded small">reset my password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection