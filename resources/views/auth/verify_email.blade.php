@extends("general_base")
@section("title") Verify Your Email @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
  <div class="breadcrumbs">
    <a href="{{ route('home') }}"><i class="las la-home"></i></a>
    <a href="{{ route('verification.notice') }}" class="active">Verify Your Email</a>
  </div>
</div>
<!-- verify email -->
<div class="section_padding mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7">
                <div class="padding_default shadow_sm">
                    <h2 class="title_2">Thanks for signing up 🎉</h2>
                    <p class="text_md mb-4">Before getting started, could you verify your email address by clicking on the link we just emailed to you?
                        <br><br>
                        If you didn't receive the email, we will gladly send you another.</p>
                    <form action="{{ route('verification.send') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 text-center mb-3">
                                @if (session('status') == 'verification-link-sent')
                                <div class="alert alert-info fade show" role="alert">A new verification link has been sent to the email address you provided during registration.</div>
                                @endif
                                @if($errors->any() || session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    @if(session('error'))
                                        {{ session('error') }}
                                    @else
                                    <ul class="my-0 mx-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    </ul>
                                    @endif
                                </div>
                                @endif
                                <div class="col-12 text-center">
                                    <button type="submit" class="default_btn xs_btn rounded px-4 d-block w-100">Resend Verification Email</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection