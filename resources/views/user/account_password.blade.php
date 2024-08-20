@extends("general_base")
@section("title") Change Password @endsection
@section("content")
<!-- breadcrumbs -->
<div class="container">
	<div class="breadcrumbs">
		<a href="{{ route('home') }}"><i class="las la-home"></i></a>
		<a href="{{ route('user_account') }}">My Account</a>
		<a href="{{ route('user_account_change_password') }}" class="active"></a>
	</div>
</div>
<!-- account -->
<div class="my_account_wrap section_padding_b">
	<div class="container">
		<div class="row">
			<!--  account sidebar  -->
			@include('partial.account_sidebar')
			<!-- account content -->
			<div class="col-lg-9">
                <div class="acprof_info_wrap shadow_sm">
                    <h4 class="text_xl mb-3">Change Password</h4>
                    <form action="{{ route('user_account_change_password_update') }}" method="POST">
                        @csrf
                        <div class="row flex-column">
                            <div class="col-md-6">
                                <div class="single_billing_inp">
                                    <label>Current Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="current_password" id="current_password" placeholder="Enter current password" required>
                                        <span class="icon toggle-password" data-target="current_password"><i class="las la-eye-slash"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_billing_inp">
                                    <label>New Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="new_password" id="new_password" placeholder="Enter new password" min="6" required>
                                        <span class="icon toggle-password" data-target="new_password"><i class="las la-eye-slash"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_billing_inp">
                                    <label>Confirm Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="password_confirmation" id="confirm_password" placeholder="Confirm new password" required>
                                        <span class="icon toggle-password" data-target="confirm_password"><i class="las la-eye-slash"></i></span>
                                    </div>
                                </div>
                            </div>                            
                            <div class="col-12 acprof_subbtn">
                                <button type="submit" class="default_btn rounded small">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("script")
<script>
$(document).ready(function() {
    $('.toggle-password').click(function() {
        let target = $('#' + $(this).data('target'));
        let icon = $(this).find('i');
        if (target.attr('type') === 'password') {
            target.attr('type', 'text');
            icon.removeClass('las la-eye-slash').addClass('las la-eye');
        } else {
            target.attr('type', 'password');
            icon.removeClass('las la-eye').addClass('las la-eye-slash');
        }
    });
});
</script>
@endsection