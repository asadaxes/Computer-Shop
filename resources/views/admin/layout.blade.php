@extends("admin_base")
@section("title") Layout Customization @endsection
@section("style")
<style>
img.slider_img {
    width: 300px;
}
.image_container {
    position: relative;
    display: inline-block;
}
.remove_icon {
    position: absolute;
    top: 10px;
    right: 10px;
    color: white;
    background-color: red;
    border-radius: 50%;
    padding: 10px;
    cursor: pointer;
    z-index: 10;
}
img.ac_list_img{
    height: 40px;
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12">
<h5 class="text-dark">Layout Customization</h5>
</div>
<div class="col-12">
<div class="card card-body pt-0">
<div class="row">
    <div class="col-md-8 mt-3">
        <div class="border-bottom text-center mb-3">
            <small class="text-muted">Sliders</small>
        </div>
        <div class="card card-body p-2">
            <form action="{{ route('admin_layout_update_slider') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="d-flex justify-content-between">
                    <input type="file" name="new_sliders" required>
                    <input type="hidden" name="sliders" value="{{ $layout->header_sliders }}">
                    <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                </div>
            </form>
        </div>
        <div class="row">
            @foreach(json_decode($layout->header_sliders, true) as $slider)
            <div class="col-md-4 col-6 mb-3">
                <div class="image_container">
                    <img src="{{ Storage::url($slider) }}" class="img-fluid rounded slider_img">
                    <a href="{{ route('admin_layout_remove_slider', ['slider' => $slider]) }}"><i class="fas fa-times remove_icon"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-4 mt-3">
        <div class="border-bottom text-center mb-3">
            <small class="text-muted">Featured Poster (html supported)</small>
        </div>
        <form action="{{ route('admin_layout_update_fp') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 d-flex flex-column align-items-center border-bottom pb-3 mb-3">
                <img src="{{ Storage::url($layout->fp_img_1) }}" class="img-fluid rounded mb-2" width="200px">
                <input type="file" name="fp_img_1">
                <input type="text" name="fp_text_1" class="form-control mt-2" placeholder="poster caption" value="{{ $layout->fp_text_1 }}" required>
            </div>
            <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                <img src="{{ Storage::url($layout->fp_img_2) }}" class="img-fluid rounded mb-2" width="200px">
                <input type="file" name="fp_img_2">
                <input type="text" name="fp_text_2" class="form-control mt-2" placeholder="poster caption" value="{{ $layout->fp_text_2 }}" required>
            </div>
            <div class="col-12 text-center mt-3">
                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
            </div>
        </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
<div class="card card-body">
@php
$conteiner = json_decode($layout->container, true);
@endphp
<form action="{{ route('admin_layout_update_container') }}" method="POST">
@csrf
<div class="row">
<div class="col-12 border-bottom text-center mb-3">
    <small class="text-muted">Featured Container</small>
</div>
<div class="col-md-4 mb-md-0 mb-3 text-center">
    <img src="{{ asset('assets/icons/delivery_bike.png') }}" class="img-fluid mb-2" width="80px">
    <input type="text" name="container_1_h" class="form-control mb-1" value="{{ $conteiner[0]['h'] ?? '' }}" required>
    <input type="text" name="container_1_p" class="form-control" value="{{ $conteiner[0]['p'] ?? '' }}" required>
</div>
<div class="col-md-4 mb-md-0 mb-3 text-center">
    <img src="{{ asset('assets/icons/money_back.png') }}" class="img-fluid mb-2" width="80px">
    <input type="text" name="container_2_h" class="form-control mb-1" value="{{ $conteiner[1]['h'] ?? '' }}" required>
    <input type="text" name="container_2_p" class="form-control" value="{{ $conteiner[1]['p'] ?? '' }}" required>
</div>
<div class="col-md-4 mb-md-0 text-center">
    <img src="{{ asset('assets/icons/24_hour_service.png') }}" class="img-fluid mb-2" width="80px">
    <input type="text" name="container_3_h" class="form-control mb-1" value="{{ $conteiner[2]['h'] ?? '' }}" required>
    <input type="text" name="container_3_p" class="form-control" value="{{ $conteiner[2]['p'] ?? '' }}" required>
</div>
<div class="col-12 text-center mt-3">
    <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
</div>
</div>
</form>
</div>
<div class="card card-body">
<form action="{{ route('admin_layout_update_parallax_banner') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
<div class="col-12 border-bottom text-center mb-3">
    <small class="text-muted">Parallax Banner</small>
</div>
<div class="col-12 d-flex flex-column align-items-center mb-md-0 mb-3">
    <img src="{{ Storage::url($layout->parallax_banner) }}" class="img-fluid rounded mb-2" width="500px">
    <input type="file" name="parallax_banner">
</div>
<div class="col-12 text-center mt-3">
    <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
</div>
</div>
</form>
</div>
<div class="card card-body">
<div class="row">
<div class="col-12 border-bottom text-center mb-3">
    <small class="text-muted">Accessories List</small>
</div>
<div class="col-12 mb-3">
<form action="{{ route('admin_layout_ac_list_add') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-6 mx-auto d-flex">
        <input type="file" name="icon" required>
        <input type="text" name="name" class="form-control" required>
        <button type="submit" class="btn btn-success btn-sm">Add</button>
    </div>
</div>
</form>
</div>
<div class="col-md-10 mx-auto">
<table class="table table-border text-center">
<tbody>
    @forelse ($ac_list as $list)
    <tr>
        <td><img src="{{ Storage::url($list->icon) }}" class="img-fluid ac_list_img"></td>
        <td>{{ $list->name }}</td>
        <td>
            <form action="{{ route('admin_layout_ac_list_remove') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $list->id }}">
                <button type="submit" class="btn btn-light btn-sm"><i class="fas fa-circle-minus text-danger"></i></button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="3" class="text-muted text-center">no results found!</td>
    </tr>
    @endforelse
</tbody>
</table>
</div>
</div>
</div>
@endsection
@section("script")

@endsection