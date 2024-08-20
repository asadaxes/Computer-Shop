@extends("admin_base")
@section("title") Sub-Categories @endsection
@section("style")

@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Sub-Categories</h5>
</div>
<div class="col-12 d-flex justify-content-end mb-3">
<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#add_sub_category_modal"><i class="fas fa-plus"></i> Add New Sub-Category</button>
</div>
<div class="col-12 mb-3">
<form method="GET">
    <div class="input-group">
        <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Search by category names..." required>
        <div class="input-group-prepend">
            <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <a href="{{ route('admin_sub_category_list') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-12">
<table class="table table-bordered text-center bg-white">
<thead class="bg-dark">
    <tr>
        <th>#</th>
        <th>Category</th>
        <th>Sub-Category</th>
        <th>Total Products</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
@forelse ($sub_categories_data as $sub_category)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $sub_category->category->name }}</td>
    <td>{{ $sub_category->name }}</td>
    <td>{{ $sub_category->products->count() }}</td>
    <td>
        <button type="button" class="btn btn-warning btn-sm edit_sub_category_modal_btn" data-toggle="modal" data-target="#edit_sub_category_modal" data-id="{{ $sub_category->id }}" data-cat_id="{{ $sub_category->category_id  }}" data-name="{{ $sub_category->name }}"><i class="fas fa-edit"></i> Edit</button>
        <form action="{{ route('admin_sub_category_delete') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="id" value="{{ $sub_category->id }}">
            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
        </form>
    </td>
</tr>
@empty
<tr>
  <td colspan="5" class="text-muted">no categories found!</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>

<!-- add category modal -->
<div class="modal fade" id="add_sub_category_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark"><i class="fas fa-th-list"></i> Add Sub-Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin_sub_category_add') }}" method="POST">
      <div class="modal-body bg-light">
        @csrf
        <label for="categories" class="mb-1">Select Category</label>
        <select name="category_id" id="categories" class="custom-select mb-3">
          <option selected disabled>Select one</option>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
        <label for="name" class="mb-1">Give a name for new Sub-Category</label>
        <input type="text" name="name" class="form-control" id="name" required>
      </div>
      <div class="modal-footer d-flex justify-content-between p-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- edit category modal -->
<div class="modal fade" id="edit_sub_category_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark"><i class="fas fa-border-all"></i> Edit Sub-Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin_sub_category_edit') }}" method="POST">
      <div class="modal-body bg-light">
        @csrf
        <label for="categories" class="mb-1">Select Category</label>
        <select name="category_id" id="categories" class="custom-select mb-3">
          @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
        <label for="edit_category_name" class="mb-1">Update sub-category name</label>
        <input type="text" name="name" class="form-control" id="edit_sub_category_name" required>
        <input type="hidden" name="id" id="edit_sub_category_id">
      </div>
      <div class="modal-footer d-flex justify-content-between p-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Save Changes</button>
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
$(".edit_sub_category_modal_btn").click(function(){
  let subCategoryId = $(this).data("id");
  let subCategoryName = $(this).data("name");
  let subCategoryCatId = $(this).data("cat_id");
  $("#edit_sub_category_name").val(subCategoryName);
  $("#edit_sub_category_id").val(subCategoryId);
  $("#categories option").each(function() {
    if ($(this).val() == subCategoryCatId) {
      $(this).prop("selected", true);
    }
  });
});
</script>
@endsection