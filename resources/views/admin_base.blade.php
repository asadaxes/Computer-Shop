<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <link rel="shortcut icon" href="{{ Storage::url($settings->favicon) }}" />
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Figtree:400,500,600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('admin/css/dashboard.css') }}">
  @yield("stylesheet")
  <title>{{ $settings->title_admin }} - @yield("title")</title>
</head>
<style>
body{
  font-family: "Figtree", sans-serif;
}
.logo_img{
  margin-left: 0.8rem;
  max-height: 40px;
  width: auto;
}
.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
  background-color: #f79f1f;
  color: #fff;
}
.cursor_pointer{
  cursor: pointer;
}
</style>
@yield("style")
<body class="hold-transition sidebar-mini">
<!-- body wrapper :start -->
<div class="wrapper">
<!-- navbar :start -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="javascript:void(0)" class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- navbar :end-->
  <!-- left sidebar :start -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin_dashboard') }}" class="brand-link py-2">
      <img src="{{ Storage::url($settings->logo_admin) }}" class="logo_img">
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-2 d-flex">
        <div class="image">
          <img src="{{ Storage::url( auth()->user()->avatar ) }}" class="img-circle elevation-1">
        </div>
        <div class="info">
          <a href="{{ route('admin_users_view', ['uid' => auth()->user()->id]) }}" class="d-block">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</a>
        </div>
      </div>

      <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('admin_dashboard') }}" class="nav-link {{ isset($active_page) && $active_page == 'dashboard' ? 'active' : '' }}">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin_orders') }}" class="nav-link {{ isset($active_page) && $active_page == 'orders' ? 'active' : '' }}">
              <i class="nav-icon fas fa-folder-tree"></i>
              <p>Orders <span class="badge badge-light right">{{ $incomplete_orders }}</span></p>
            </a>
          </li>
          <li class="nav-item {{ isset($active_page) && ($active_page == 'users_list' || $active_page == 'users_add' || $active_page == 'users_view') ? 'menu-is-opening menu-open' : '' }}">
            <a href="javascript:void(0)" class="nav-link {{ isset($active_page) && ($active_page == 'users_list' || $active_page == 'users_add' || $active_page == 'users_view') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>Users <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview" style="display: {{ isset($active_page) && ($active_page == 'users_list' || $active_page == 'users_add' || $active_page == 'users_view') ? 'block' : 'none' }};">
              <li class="nav-item">
                <a href="{{ route('admin_users_add') }}" class="nav-link">
                  <i class="{{ isset($active_page) && $active_page == 'users_add' ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                  <p>Add</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin_users_list') }}" class="nav-link">
                  <i class="{{ isset($active_page) && ($active_page == 'users_list' || $active_page == 'users_view') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin_brands') }}" class="nav-link {{ isset($active_page) && $active_page == 'brands' ? 'active' : '' }}">
              <i class="nav-icon fas fa-b"></i>
              <p>Brands</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin_category_list') }}" class="nav-link {{ isset($active_page) && $active_page == 'category' ? 'active' : '' }}">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>Category</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin_sub_category_list') }}" class="nav-link {{ isset($active_page) && $active_page == 'sub_category' ? 'active' : '' }}">
              <i class="nav-icon fas fa-table-list"></i>
              <p>Sub-Category</p>
            </a>
          </li>
          <li class="nav-item {{ isset($active_page) && ($active_page == 'products_list' || $active_page == 'products_add' || $active_page == 'products_view' || $active_page == 'products_recommends' || $active_page == 'products_best_deals' || $active_page == 'products_flash_sale') ? 'menu-is-opening menu-open' : '' }}">
            <a href="javascript:void(0)" class="nav-link {{ isset($active_page) && ($active_page == 'products_list' || $active_page == 'products_add' || $active_page == 'products_recommends' || $active_page == 'products_best_deals' || $active_page == 'products_flash_sale') ? 'active' : '' }}">
              <i class="nav-icon fas fa-boxes-stacked"></i>
              <p>Products <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview" style="display: {{ isset($active_page) && ($active_page == 'products_list' || $active_page == 'products_add' || $active_page == 'products_view' || $active_page == 'products_recommends' || $active_page == 'products_best_deals' || $active_page == 'products_flash_sale') ? 'block' : 'none' }};">
              <li class="nav-item">
                <a href="{{ route('admin_products_add') }}" class="nav-link">
                  <i class="{{ isset($active_page) && $active_page == 'products_add' ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                  <p>Add</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin_products_list') }}" class="nav-link">
                  <i class="{{ isset($active_page) && ($active_page == 'products_list' || $active_page == 'products_view') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin_products_recommends') }}" class="nav-link">
                  <i class="{{ isset($active_page) && ($active_page == 'products_recommends') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                  <p>Recommends</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin_products_best_deals') }}" class="nav-link">
                  <i class="{{ isset($active_page) && ($active_page == 'products_best_deals') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                  <p>Best Deals</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin_products_flash_sale') }}" class="nav-link">
                  <i class="{{ isset($active_page) && ($active_page == 'products_flash_sale') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                  <p>Flash Sale</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin_coupons') }}" class="nav-link {{ isset($active_page) && $active_page == 'coupons' ? 'active' : '' }}">
              <i class="nav-icon fa fa-ticket"></i>
              <p>Coupons</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin_pages') }}" class="nav-link {{ isset($active_page) && $active_page == 'pages' ? 'active' : '' }}">
              <i class="nav-icon fa fa-file-lines"></i>
              <p>Pages</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin_faq') }}" class="nav-link {{ isset($active_page) && $active_page == 'faq' ? 'active' : '' }}">
              <i class="nav-icon fa fa-circle-question"></i>
              <p>FAQ</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin_layout') }}" class="nav-link {{ isset($active_page) && $active_page == 'layout' ? 'active' : '' }}">
              <i class="nav-icon fa fa-pager"></i>
              <p>Layout</p>
            </a>
          </li>
          <li class="nav-item {{ isset($active_page) && ($active_page == 'general' || $active_page == 'charge' || $active_page == 'env') ? 'menu-is-opening menu-open' : '' }}">
            <a href="javascript:void(0)" class="nav-link {{ isset($active_page) && ($active_page == 'general' || $active_page == 'charge' || $active_page == 'env') ? 'active' : '' }}">
              <i class="nav-icon fas fa-gear"></i>
              <p>Settings <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview" style="display: {{ isset($active_page) && ($active_page == 'general' || $active_page == 'charge' || $active_page == 'env') ? 'block' : 'none' }};">
              <li class="nav-item">
                <a href="{{ route('admin_settings_general') }}" class="nav-link">
                  <i class="{{ isset($active_page) && $active_page == 'general' ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin_settings_charges') }}" class="nav-link">
                  <i class="{{ isset($active_page) && ($active_page == 'charge') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                  <p>Charges</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin_settings_env') }}" class="nav-link">
                  <i class="{{ isset($active_page) && ($active_page == 'env') ? 'fas' : 'far' }} fa-circle nav-icon"></i>
                  <p>Advance</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="https://dashboard.tawk.to/#/dashboard" class="nav-link" target="_blank">
              <i class="nav-icon fa fa-headset"></i>
              <p>Chat Assist</p>
            </a>
          </li>
          <li class="nav-item">
            <hr class="bg-white my-2">
          </li>
          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link">
              <i class="nav-icon fa fa-power-off"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
<!-- left sidebar :end -->
<!-- content wrapper :start -->
<div class="content-wrapper">
<div class="content">
<div class="container-fluid pt-3">
@if(session('success'))
<div class="position-fixed px-3" style="z-index: 5; right: 0; top: 5;">
  <div class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
    <div class="toast-body bg-success">
      {{ session('success') }}
    </div>
  </div>
</div>
@endif
@if(session('info'))
<div class="position-fixed px-3" style="z-index: 5; right: 0; top: 5;">
  <div class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
    <div class="toast-body bg-info">
      {{ session('info') }}
    </div>
  </div>
</div>
@endif
@if(session('error'))
<div class="position-fixed px-3" style="z-index: 5; right: 0; top: 5;">
  <div class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
    <div class="toast-body bg-danger">
      {{ session('error') }}
    </div>
  </div>
</div>
@endif
@if ($errors->any())
<div class="position-fixed px-3" style="z-index: 5; right: 0; top: 5;">
  <div class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
    <div class="toast-body bg-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
@endif
@yield("content")
</div>
</div>
</div>
<!-- content wrapper :end -->
</div>
<!-- body wrapper :end -->
<script src="{{ asset('admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/js/dashboard.min.js') }}"></script>
@yield("script")
<script>
document.addEventListener('DOMContentLoaded', function() {
  let toastElement = document.querySelector('.toast');
  if (toastElement) {
    let toast = new bootstrap.Toast(toastElement);
    toast.show();
  }
});
</script>
</body>
</html>