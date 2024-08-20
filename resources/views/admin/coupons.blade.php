@extends("admin_base")
@section("title") Coupons Code @endsection
@section("style")

@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Coupons List</h5>
</div>
<div class="col-12 d-flex justify-content-end mb-3">
<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#add_coupon_modal"><i class="fas fa-plus"></i> Add New Coupon</button>
</div>
<div class="col-12 mb-3">
<form method="GET">
    <div class="input-group">
        <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Search by coupon codes..." required>
        <div class="input-group-prepend">
            <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <a href="{{ route('admin_coupons') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-12">
<table class="table table-bordered text-center bg-white">
<thead class="bg-dark">
    <tr>
        <th>#</th>
        <th>Code</th>
        <th>Value</th>
        <th>Type</th>
        <th>Valid From</th>
        <th>Valid Until</th>
        <th>Used</th>
        <th>Usage Limit</th>
        <th>Created at</th>
        <th><i class="fas fa-circle-minus"></i></th>
    </tr>
</thead>
<tbody>
@forelse ($coupons as $coupon)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td class="text-dark font-weight-bold">{{ $coupon->code }}</td>
    <td>{{ $coupon->type == 'fixed' ? '৳'.$coupon->value : $coupon->value.'%' }}</td>
    <td>{{ ucfirst($coupon->type) }}</td>
    <td>
        <div class="d-flex flex-column">
            <small>{{ \Carbon\Carbon::parse($coupon->valid_from)->format('h:i A') }}</small>
            <small>{{ \Carbon\Carbon::parse($coupon->valid_from)->format('d M, Y') }}</small>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column">
            <small>{{ \Carbon\Carbon::parse($coupon->valid_until)->format('h:i A') }}</small>
            <small>{{ \Carbon\Carbon::parse($coupon->valid_until)->format('d M, Y') }}</small>
        </div>
    </td>
    <td>{{ $coupon->usage_count }}</td>
    <td>{{ $coupon->usage_limit }}</td>
    <td>
        <div class="d-flex flex-column">
            <small>{{ \Carbon\Carbon::parse($coupon->created_at)->format('h:i A') }}</small>
            <small>{{ \Carbon\Carbon::parse($coupon->created_at)->format('d M, Y') }}</small>
        </div>
    </td>
    <td>
        <form action="{{ route('admin_coupons_remove') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="id" value="{{ $coupon->id }}">
            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
        </form>
    </td>
</tr>
@empty
<tr>
  <td colspan="10" class="text-muted">no coupons found!</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
<!-- add coupon modal -->
<div class="modal fade" id="add_coupon_modal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark"><i class="fas fa-ticket"></i> Add New Coupon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin_coupons_add') }}" method="POST">
      <div class="modal-body bg-light">
        @csrf
        <div class="row">
            <div class="col-md-7 mx-auto mb-3">
                <label for="code" class="mb-1">Give a Unique Code for New Coupon</label>
                <input type="text" name="code" class="form-control" id="code" placeholder="eg: ABC123" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="value" class="mb-1">Value/Discount</label>
                <input type="tel" name="value" class="form-control" id="value" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="type" class="mb-1">Select Coupon Type</label>
                <select name="type" id="type" class="custom-select" required>
                    <option value="fixed">Fixed</option>
                    <option value="percentage">Percentage</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="valid_from" class="mb-1">Valid From</label>
                <input type="datetime-local" name="valid_from" class="form-control" id="valid_from" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="valid_until" class="mb-1">Valid Until</label>
                <input type="datetime-local" name="valid_until" class="form-control" id="valid_until" required>
            </div>
            <div class="col-md-6">
                <label for="usage_limit" class="mb-1">Usage Limit</label>
                <input type="number" name="usage_limit" class="form-control" id="usage_limit" placeholder="how many times this coupon can be usable?" required>
            </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-between p-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Submit</button>
      </div>
      </form>
    </div>
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