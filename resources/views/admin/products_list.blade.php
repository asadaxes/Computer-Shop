@extends("admin_base")
@section("title") Products List @endsection
@section("style")
<style>
img.product_list_img{
    width: 80px;
    height: 45px;
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Products List</h5>
</div>
<div class="col-12 mb-3">
<form method="GET">
    <div class="input-group">
        <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Search by product title, sku/code, condition, regular or sale price tags, featured or specification..." required>
        <div class="input-group-prepend">
            <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <a href="{{ route('admin_products_list') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-12">
<div class="card card-body p-0">
<div class="table-responsive">
<table class="table table-bordered text-center">
<thead class="bg-dark">
    <tr>
        <th>#</th>
        <th>Product</th>
        <th>SKU/Code</th>
        <th>Price <i class="fa-solid fa-bangladeshi-taka-sign"></i></th>
        <th>Quantity</th>
        <th>Brand</th>
        <th>Category</th>
        <th>Condition</th>
        <th>Publish Date</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
@forelse ($products as $product)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
          <a href="{{ route('admin_products_view', ['id' => $product->id]) }}" class="d-flex align-items-center text-dark">
            @if($product->images)
                @php $images = json_decode($product->images, true); @endphp
                <img src="{{ Storage::url($images[0]) }}" class="img-fluid rounded product_list_img mr-1">
            @endif
            <span>{{ Str::limit($product->title, 50) }}</span>
          </a>
        </td>
        <td>{{ $product->sku }}</td>
        <td>
          <div class="d-flex flex-column">
            @if($product->regular_price)<span title="regular price"><s>{{ $product->regular_price }} tk</s></span>@endif
            <span title="sale price">{{ $product->sale_price }} tk</span>
          </div>
        </td>
        <td>{{ $product->quantity }}</td>
        <td>{{ optional($product->brand)->name }}</td>
        @if($product->sub_category_id)
        <td>
          <div class="d-flex flex-column">
            <small>{{ $product->category->name }}</small>
            <small><i class="fa-solid fa-arrow-turn-down fa-sm text-muted"></i></small>
            <small>{{ $product->subcategory->name }}</small>
          </div>
        </td>
        @else
        <td>{{ $product->category->name }}</td>
        @endif
        <td>{{ $product->condition }}</td>
        <td>{{ \Carbon\Carbon::parse($product->publish_date)->format('M d, Y') }}</td>
        <td>
            <a href="{{ route('admin_products_view', ['id' => $product->id]) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_product_modal" data-id="{{ $product->id }}" data-img="{{ Storage::url($images[0]) }}" data-title="{{ $product->title }}" data-quantity="{{ $product->quantity }}"><i class="fas fa-trash-alt"></i></button>
        </td>
    </tr>
@empty
    <tr>
      <td colspan="10" class="text-center text-muted">no products found!</td>
    </tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
<div class="col-12 d-flex justify-content-between align-items-baseline py-4">
<small class="text-dark">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results</small>
{{ $products->links("partial.pagination") }}
</div>
</div>

<div class="modal fade" id="delete_product_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle"></i> Delete This Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-light d-flex flex-column justify-content-center align-items-center">
        <h6 class="text-danger">Are you sure? do you really want to delete this product?</h6>
        <img class="img-fluid rounded product_list_img del_preview_img mb-2">
        <span class="text-dark del_preview_title mb-1"></span>
        <span class="badge border del_preview_quantity"></span>
      </div>
      <div class="modal-footer d-flex justify-content-between p-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <form action="{{ route('admin_products_delete') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="product_id">
            <button type="submit" class="btn btn-danger">Yes, Confirm</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section("script")
<script>
$('#delete_product_modal').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget);
  let id = button.data('id');
  let img = button.data('img');
  let title = button.data('title');
  let quantity = button.data('quantity');
  let modal = $(this);
  modal.find('#product_id').val(id);
  modal.find('.del_preview_img').attr('src', img);
  modal.find('.del_preview_title').text(title);
  modal.find('.del_preview_quantity').text('Quantity: ' + quantity);
});

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