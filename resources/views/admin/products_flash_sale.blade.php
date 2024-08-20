@extends("admin_base")
@section("title") Flash Sale Products @endsection
@section("style")
<style>
img.product_list_img{
  width: 80px;
  height: 50px;
}
ul.list-group{
  max-height: 60vh;
  overflow-y: auto;
}
ul.list-group::-webkit-scrollbar {
  width: 12px;
}
ul.list-group::-webkit-scrollbar-track {
  background: #f79f1f;
}
ul.list-group::-webkit-scrollbar-thumb {
  background-color: #f79f1f;
  border-radius: 10px;
  border: 3px solid #f1f1f1;
}
ul.list-group::-webkit-scrollbar-thumb:hover {
  background: #f79f1f;
}
ul.list-group {
  scrollbar-width: thin;
  scrollbar-color: #f79f1f #f1f1f1;
}
ul.list-group {
  -ms-overflow-style: -ms-autohiding-scrollbar;
}
.primary_text{
  color: #f79f1f;
}
</style>
@endsection
@section("content")
<div class="row mb-md-0 mb-4">
<div class="col-12 mb-3">
  <h5 class="text-dark border-bottom">Add/Remove Flash Sale Products</h5>
</div>
<div class="col-md-6 mb-4">
<div class="row">
<div class="col-12 mb-2">
<form method="GET">
  <div class="input-group">
    <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Find by product title, sku/code, condition, regular or sale price tags, featured or specification..." required>
    <div class="input-group-prepend">
      <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
    </div>
  </div>
  <a href="{{ route('admin_products_flash_sale') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-12 mb-md-0">
  <ul class="list-group">
    @foreach($all_products as $pd)
      <?php $img = json_decode($pd->images, true); ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <img src="{{ Storage::url($img[0]) }}" class="img-fluid rounded product_list_img mr-2">
          <h6 class="text-dark mb-0">{{ Str::limit($pd->title, 50) }}</h6>
        </div>
        <form action="{{ route('admin_products_flash_sale_updater') }}" method="POST">
          @csrf
          <input type="hidden" name="id" value="{{ $pd->id }}">
          <button type="submit" class="btn"><i class="fa-solid fa-circle-chevron-right fa-lg primary_text cursor_pointer"></i></button>
        </form>
      </li>
    @endforeach
  </ul>
  <div class="d-flex justify-content-center align-items-baseline py-4">
    {{ $all_products->links("partial.pagination") }}
  </div>
</div>
</div>
</div>
<div class="col-md-6 col-12">
<h3 class="text-muted text-center mb-4">Flash Sale Products List</h3>
<form action="{{ route('admin_products_flash_sale_status_updater') }}" method="POST">
@csrf
<div class="row">
<div class="col-md-6 mb-md-0 mb-2">
    <label for="from_date" class="text-dark mb-0">Start From</label>
    <input type="datetime-local" name="from_date" class="form-control" id="from_date" value="{{ optional($flash_sale->from_date)->format('Y-m-d\TH:i') }}" required>
</div>
<div class="col-md-6">
    <label for="to_date" class="text-dark mb-0">End Date</label>
    <input type="datetime-local" name="to_date" class="form-control" id="to_date" value="{{ optional($flash_sale->to_date)->format('Y-m-d\TH:i') }}" required>
</div>
<div class="col-md-6 my-2">
    <label for="status" class="text-dark mb-0">Status</label>
    <select name="status" class="custom-select" id="status" required>
        <option value="Upcoming" {{ $flash_sale && $flash_sale->status == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
        <option value="Active" {{ $flash_sale && $flash_sale->status == 'Active' ? 'selected' : '' }}>Active</option>
        <option value="Expired" {{ $flash_sale && $flash_sale->status == 'Expired' ? 'selected' : '' }}>Expired</option>
    </select>
</div>
<div class="col-md-6 d-flex justify-content-center align-items-center mb-md-0 mb-3 pt-md-4 pt-0">
    <button type="submit" class="btn btn-success w-100">Update</button>
</div>
</div>
</form>
<ul class="list-group" id="sortable_list">
    @foreach($flash_sale_products as $pd)
      <?php $img = json_decode($pd->images, true); ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ Storage::url($img[0]) }}" class="img-fluid rounded product_list_img mr-2">
                <h6 class="text-dark mb-0">{{ Str::limit($pd->title, 50) }}</h6>
            </div>
            <form action="{{ route('admin_products_flash_sale_updater') }}" method="POST">
            @csrf
                <input type="hidden" name="id" value="{{ $pd->id }}">
                <button type="submit" class="btn"><i class="fa-solid fa-circle-chevron-left fa-lg text-danger cursor_pointer"></i></button>
            </form>
        </li>
    @endforeach
</ul>
</div>
</div>
@endsection
@section("script")
<script>
function getSearchTermFromUrl() {
  let urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('search') || '';
}
window.onload = function() {
  document.getElementById('search_field').value = getSearchTermFromUrl();
  if(getSearchTermFromUrl()){
    document.getElementById('reset_btn').classList.remove('d-none');
  }
};
</script>
@endsection