@extends("admin_base")
@section("title") FAQ @endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark border-bottom">FAQ</h5>
</div>
<div class="col-12 d-flex justify-content-end mb-3">
<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#create_modal"><i class="fas fa-plus"></i> Create New FAQ</button>
</div>
<div class="col-12 mb-3">
<form method="GET">
@csrf
    <div class="input-group">
        <input type="text" class="form-control py-4" name="search" id="search_field" placeholder="Search pages by questions..." required>
        <div class="input-group-prepend">
            <button type="submit" class="input-group-text bg-light"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <a href="{{ route('admin_faq') }}" class="text-muted d-none" id="reset_btn"><small>reset</small></a>
</form>
</div>
<div class="col-md-6 mx-auto">
<ul class="list-group">
@forelse ($faqs as $faq)
    <li class="list-group-item cursor_pointer faq_list" data-toggle="modal" data-target="#view_modal" data-id="{{ $faq->id }}" data-qus="{{ $faq->question }}" data-ans="{{ $faq->answer }}">{{ $loop->iteration }}. {{ $faq->question }}</li>
@empty
    <li class="list-group-item text-muted text-center">no faqs found!</li>
@endforelse
</ul>
</div>
</div>

<!-- create -->
<div class="modal fade" id="create_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create New FAQ</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form action="{{ route('admin_faq_add') }}" method="POST">
    @csrf
      <div class="modal-body bg-light pb-2">
        <label for="question" class="text-dark mb-0">Question</label>
        <input type="text" name="question" class="form-control mb-3" id="question" required>
        <label for="answer" class="text-dark mb-0">Answer</label>
        <textarea name="answer" class="form-control" id="answer" required></textarea>
      </div>
      <div class="modal-footer d-flex justify-content-between p-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Publish Now</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- view -->
<div class="modal fade" id="view_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('admin_faq_edit') }}" method="POST">
        @csrf
        <div class="modal-body bg-light">
            <label for="question" class="text-dark mb-0">Question</label>
            <input type="text" name="question" class="form-control mb-3" id="view_question" required>
            <label for="answer" class="text-dark mb-0">Answer</label>
            <textarea name="answer" class="form-control" id="view_answer" required></textarea>
          <input type="hidden" name="id" id="view_id">
        </div>
        <div class="modal-footer d-flex justify-content-between p-0">
          <button type="button" class="btn btn-danger" id="delete_faq_btn">Delete</button>
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<form action="{{ route('admin_faq_delete') }}" method="POST" id="delete_form">
@csrf
<input type="hidden" name="id" id="delete_id">
</form>
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

$('#view_modal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let id = button.data('id');
    let qus = button.data('qus');
    let ans = button.data('ans');
    let modal = $(this);
    modal.find('#view_question').val(qus);
    modal.find('#view_answer').val(ans);
    modal.find('#view_id').val(id);
    $('#delete_id').val(id);
});

$('#delete_faq_btn').click(function(){
    $('#delete_form').submit();
});
</script>
@endsection