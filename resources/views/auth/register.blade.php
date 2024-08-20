@extends("general_base")
@section("title") Sign in to continue @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
  <div class="breadcrumbs">
    <a href="{{ route('home') }}"><i class="las la-home"></i></a>
    <a href="{{ route('register') }}" class="active">Register</a>
  </div>
</div>
<!--register wrap-->
<div class="register_wrap section_padding_b">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-5 col-lg-7 col-md-9">
        <div class="register_form padding_default shadow_sm">
          <h4 class="title_2">Create an account</h4>
					<p class="mb-4 text_md">Register here if you are a new customer.</p>
          <form action="{{ route('register_handler') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="single_billing_inp">
                  <label>First Name <span>*</span></label>
                  <input type="text" name="first_name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="single_billing_inp">
                  <label>Last Name <span>*</span></label>
                  <input type="text" name="last_name" required>
                </div>
              </div>
              <div class="col-12">
                <div class="single_billing_inp">
                  <label>Email <span>*</span></label>
                  <input type="email" name="email" placeholder="example@mail.com" required>
                </div>
              </div>
              <div class="col-12">
                <div class="single_billing_inp">
                  <label>Password <span>*</span></label>
                  <input type="password" name="password" placeholder="******" required>
                </div>
              </div>
              <div class="col-12">
                <div class="single_billing_inp">
                  <label>Confirm Password <span>*</span></label>
                  <input type="password" name="password_confirmation" placeholder="******" required>
                </div>
              </div>
              <div class="mb-3">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
              </div>
              <div class="mb-3">
                <div class="remember-checkbox">
                  <input type="checkbox" name="agreement" id="agreement">
                  <label for="agreement">Accept our <a href="/p/privacy-olicy">Privacy Policy</a> and <a href="/p/terms-and-conditions">Terms & Conditions</a></label>
                </div>
              </div>
              <div class="col-12 mt-3">
                <button type="submit" class="default_btn xs_btn rounded px-4 d-block w-100">Register</button>
              </div>
            </div>
          </form>

          <p class="text-center mt-3 mb-0">Already have an account? please <a href="{{ route('signin') }}">Login here</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection