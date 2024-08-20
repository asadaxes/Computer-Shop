@extends("general_base")
@section("title") Set New Password @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
  <div class="breadcrumbs">
    <a href="{{ route('home') }}"><i class="las la-home"></i></a>
    <a href="" class="active">Set New Passowrd</a>
  </div>
</div>
<!-- set new password -->
<div class="section_padding mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7">
                <div class="padding_default shadow_sm">
                    <form action="{{ route('password.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <h2 class="title_2">Set New Password</h2>
                        <p class="text_md">Set a new password for your account. Choose a strong password that you can remember.</p>
                        <div class="single_billing_inp">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="Email address" required>
                        </div>
                        <div class="single_billing_inp">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Enter Password" required>
                        </div>
                        <div class="single_billing_inp">
                        <label>Password</label>
                        <input type="password" name="password_confirmation" placeholder="Confirm password" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="default_btn rounded small">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection