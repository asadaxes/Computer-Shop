@extends("admin_base")
@section("title") Env Config @endsection
@section("content")
<form action="{{ route('admin_settings_env_updater') }}" method="POST">
@csrf
<div class="row">
<div class="col-12 d-flex justify-content-between align-items-center mb-2">
<h5 class="text-dark mb-0">Env Config</h5>
<button type="submit" class="btn btn-success btn-sm">Save Changes</button>
</div>
<div class="col-12">
<div class="card card-body p-0">
<div class="row">
<div class="col-12">
<textarea name="data" rows="25" class="form-control" required>
{{ $envContent }}
</textarea>
</div>
</div>
</div>
<small class="text-muted">Note: Saving changes may cause the server to restart.</small>
</div>
</div>
</form>
@endsection