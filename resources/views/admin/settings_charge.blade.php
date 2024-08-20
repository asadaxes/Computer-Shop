@extends("admin_base")
@section("title") Charges/Tax Config @endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark">Charges/Tax Config</h5>
</div>
<div class="col-12">
<div class="card card-body">
<form action="{{ route('admin_settings_charges_updater') }}" method="POST">
@csrf
<div class="row">
<div class="col-md-4 mx-auto">
<label for="inside_dhaka" class="text-dark mb-0">Delivery Charge Inside Dhaka</label>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text">BDT</span>
  </div>
  <input type="number" name="delivery_charge_inside" class="form-control" id="inside_dhaka" value="{{ $settings->delivery_charge_inside }}" required>
</div>
<label for="outside_dhaka" class="text-dark mb-0">Delivery Charge Outside Dhaka</label>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text">BDT</span>
  </div>
  <input type="number" name="delivery_charge_outside" class="form-control" id="outside_dhaka" value="{{ $settings->delivery_charge_outside }}" required>
</div>
<label for="tax" class="text-dark mb-0">Tax</label>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text">BDT</span>
  </div>
  <input type="number" name="tax" class="form-control" id="tax" value="{{ $settings->tax }}" required>
</div>
<div class="text-center">
    <button type="submit" class="btn btn-success">Save Changes</button>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
@endsection