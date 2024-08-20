@extends("general_base")
@section("title") Sign in to continue @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
  <div class="breadcrumbs">
    <a href="{{ route('home') }}"><i class="las la-home"></i></a>
    <a href="{{ route('signin') }}" class="active">Sign in</a>
  </div>
</div>
<!--login wrap-->
<div class="register_wrap section_padding_b">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-5 col-lg-7 col-md-9">
        <div class="register_form padding_default shadow_sm">
          <h4 class="title_2 mb-4">Sign in</h4>
          <form action="{{ route('signin_handler') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-12">
                <div class="single_billing_inp">
                  <label>Email Address <span>*</span></label>
                  <input type="email" name="email" placeholder="example@mail.com" required>
                </div>
              </div>
              <div class="col-12">
                <div class="single_billing_inp">
                  <label>Password <span>*</span></label>
                  <input type="password" name="password" placeholder="******" required>
                </div>
              </div>
              <div class="col-12 mt-2 d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="remember_me" id="remember_me">
                  <label for="remember_me" class="cursor_pointer">&nbsp;Remember Me</label>
                </div>

                <a href="{{ route('password.request') }}" class="text-color">Forgot Password?</a>
              </div>
              <div class="col-12 mb-2">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
              </div>
              <div class="col-12 mt-3">
                <button type="submit" class="default_btn xs_btn rounded px-4 d-block w-100">Sign in</button>
              </div>
            </div>
          </form>

          <div class="dif_regway my-3">
            <span class="txt">Or</span>
          </div>

          <div class="text-center my-4">
            <a class="btn bg-white text-muted border py-2" href="{{ route('google_auth') }}"><img src="{{ asset('assets/google_logo.png') }}" class="img-fluid me-2" width="20"> Sign in with Google</a>
          </div>

          <p class="text-center mt-3 mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-color">Create one</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection