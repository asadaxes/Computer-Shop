<div class="col-lg-3">
    <div class="account_sidebar">
        <div class="account_profile position-relative shadow_sm">
            <div class="acprof_img">
                <img src="{{ Storage::url( auth()->user()->avatar ) }}" class="account_sidebar_avatar" />
            </div>
            <div class="acprof_cont">
                <p>Hello,</p>
                <h4>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h4>
            </div>
            <div class="profile_hambarg d-lg-none d-block">
                <i class="las la-bars"></i>
            </div>
        </div>
        <div class="acprof_wrap shadow_sm">
            <div class="acprof_links">
                <a>
                    <h4 class="acprof_link_title">
                        <i class="lar la-id-card"></i>
                        Manage My Account
                    </h4>
                </a>
                <a href="{{ route('user_account') }}" {{ isset($active_page) && $active_page == 'account' ? 'class=active' : '' }}>Account Details</a>
                <a href="{{ route('user_account_change_password') }}" {{ isset($active_page) && $active_page == 'account_password' ? 'class=active' : '' }}>Change Password</a>
            </div>
            <div class="acprof_links">
                <a href="{{ route('user_account_orders') }}" {{ isset($active_page) && $active_page == 'account_orders' ? 'class=active' : '' }}>
                    <h4 class="acprof_link_title">
                        <i class="las la-gift"></i>
                        My Order History
                    </h4>
                </a>
            </div>
            <div class="acprof_links">
                <a href="{{ route('user_account_wishlist') }}" {{ isset($active_page) && $active_page == 'account_wishlist' ? 'class=active' : '' }}>
                    <h4 class="ac_link_title">
                        <i class="lar la-heart"></i>
                        My Wishlist
                    </h4>
                </a>
            </div>
            <div class="acprof_links border-0">
                <a href="{{ route('logout') }}">
                    <h4 class="acprof_link_title">
                        <i class="las la-power-off"></i>
                        Logout
                    </h4>
                </a>
            </div>
        </div>
    </div>
</div>