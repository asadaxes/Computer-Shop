@extends("admin_base")
@section("stylesheet")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
@endsection
@section("title") Pages @endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">Pages</h5>
</div>
<div class="col-12 d-flex justify-content-end mb-3">
<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#create_modal"><i class="fas fa-plus"></i> Create New Page</button>
</div>
<div class="col-12 mb-3">
<form method="GET">
@csrf
    <div class="input-group">
        <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Search pages by name..." required>
        <div class="input-group-prepend">
            <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <a href="{{ route('admin_pages') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-12">
<div class="row">
@forelse ($pages as $page)
<div class="col-md-3">
<div class="card card-body text-center cursor_pointer" data-toggle="modal" data-target="#edit_modal" data-id="{{ $page->id }}" data-content="{{ $page->content }}">
  <h5 class="mb-0">{{ $page->name }}</h5>
</div>
</div>
@empty
<div class="col-md-3">
<div class="card card-body text-center text-muted">
  <h5 class="mb-0">no page created yet!</h5>
</div>
</div>
@endforelse
</div>
</div>
</div>

<!-- create -->
<div class="modal fade" id="create_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create New Page</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form action="{{ route('admin_pages_add') }}" method="POST">
    @csrf
      <div class="modal-body bg-light pb-2">
        <label for="name" class="text-dark mb-0">Page title</label>
        <input type="text" name="name" class="form-control mb-3" id="name" required>
        <label for="content" class="text-dark mb-0">Write page content</label>
        <textarea name="content" id="content" required></textarea>
      </div>
      <div class="modal-footer d-flex justify-content-between p-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Publish Now</button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- edit -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title edit_modal_title"></h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin_pages_edit') }}" method="POST">
        @csrf
        <div class="modal-body bg-light">
          <label for="edit_name" class="text-dark mb-0">Page title</label>
          <input type="text" name="name" class="form-control mb-3" id="edit_name" required>
          <label for="content" class="text-dark mb-0">Write page content</label>
          <textarea name="content" id="edit_content" required></textarea>
          <input type="hidden" name="id" id="edit_id">
        </div>
        <div class="modal-footer d-flex justify-content-between p-0">
          <button type="button" class="btn btn-danger" id="delete_page_btn">Delete</button>
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<form action="{{ route('admin_pages_delete') }}" method="POST" id="delete_form">
@csrf
<input type="hidden" name="id" id="delete_id">
</form>
@endsection
@section("script")
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
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

$('#content').summernote({
  tabsize: 2,
  height: 350
});

$('#edit_content').summernote({
  tabsize: 2,
  height: 350
});

$('#edit_modal').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget);
  let id = button.data('id');
  let name = button.text();
  let content = button.data('content');
  let modal = $(this);
  modal.find('#edit_modal_title').text(name);
  modal.find('#edit_name').val(name);
  modal.find('#edit_content').summernote('code', content);
  modal.find('#edit_id').val(id);
  $('#delete_id').val(id);
});

$('#delete_page_btn').click(function(){
  $('#delete_form').submit();
});
</script>
@endsection