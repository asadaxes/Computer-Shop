@extends("admin_base")
@section("stylesheet")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
@endsection
@section("title") Add New Product @endsection
@section("style")
<style>
img.product_images_preview{
    width: 125px;
}
</style>
@endsection
@section("content")
<div class="row">
<div class="col-12 mb-2">
<h5 class="text-dark border-bottom"><a href="{{ route('admin_products_list') }}" class="text-muted">Products List</a>/Add New Product</h5>
</div>
<div class="col-12">
<div class="card card-body">
<form action="{{ route('admin_products_add_handler') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="title" class="text-dark mb-0">Title <small class="text-danger">*</small></label>
        <input type="text" name="title" class="form-control mb-3" id="title" min="10" max="150" required>
        <div class="mb-3">
            <label class="text-dark mb-0">Featured</label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="add_featured_field">
                <input type="hidden" name="featured" id="add_featured_store_field">
                <div class="input-group-prepend">
                    <button type="button" class="input-group-text" id="add_featured_btn"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <ul class="list-group" id="add_featured_ul">
            </ul>
        </div>
        <label for="description" class="text-dark mb-0">Description</label>
        <textarea name="description" class="form-control mb-3" id="description"></textarea>
        <div class="mb-3">
            <label class="text-dark mb-0">Specification</label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="add_specification_field_key" placeholder="key">
                <input type="text" class="form-control" id="add_specification_field_value" placeholder="value">
                <input type="hidden" name="specification" id="add_specification_store_field">
                <div class="input-group-prepend">
                    <button type="button" class="input-group-text" id="add_specification_btn"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div>
                <span class="badge badge-light border cursor_pointer">Processor</span>
                <span class="badge badge-light border cursor_pointer">Graphics Card</span>
                <span class="badge badge-light border cursor_pointer">Ram</span>
                <span class="badge badge-light border cursor_pointer">Storage</span>
                <span class="badge badge-light border cursor_pointer">Display</span>
                <span class="badge badge-light border cursor_pointer">Keyboard</span>
                <span class="badge badge-light border cursor_pointer">Battery</span>
                <span class="badge badge-light border cursor_pointer">Operating System</span>
                <span class="badge badge-light border cursor_pointer">Security</span>
                <span class="badge badge-light border cursor_pointer">Weight</span>
            </div>
            <table class="table table-sm text-center mt-2" id="add_specification_table">
                <tbody></tbody>
            </table>
        </div>
        <label for="tags" class="text-dark mb-0">Tags <small class="text-danger">*</small> <small class="text-muted">(separate by comma)</small></label>
        <input type="text" name="tags" class="form-control" id="tags" placeholder="eg: tag1, tag2, tag3..." required>
    </div>
    <div class="col-md-6 mb-3">
    <div class="row">
    <div class="col-md-6 mb-3">
        <label for="condition" class="text-dark mb-0">Select Condition</label>
        <select name="condition" class="custom-select" id="condition" required>
            <option selected disabled>-- select --</option>
            <option value="New">New</option>
            <option value="Used">Used</option>
            <option value="Refurbished">Refurbished</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="quantity" class="text-dark mb-0">Quantity <small class="text-danger">*</small></label>
        <input type="number" name="quantity" class="form-control mb-3" id="quantity" min="1" step="1" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="sku" class="text-dark mb-0">SKU/Code <small class="text-danger">*</small></label>
        <input type="text" name="sku" class="form-control mb-3" id="sku" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="brand" class="text-dark mb-0">Select Brand</label>
        <select name="brand_id" class="custom-select" id="brand" required>
            <option selected disabled>-- select --</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="category" class="text-dark mb-0">Select Category <small class="text-danger">*</small></label>
        <select name="category_id" class="custom-select" id="category" required>
            <option selected disabled>-- Select Category --</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="sub_category" class="text-dark mb-0">Select Sub-Category</label>
        <select name="sub_category_id" class="custom-select" id="sub_category" required>
            <option selected disabled>-- Select Sub-Category --</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="regular_price" class="text-dark mb-0">Regular Price <small class="text-muted">(Optional)</small></label>
        <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">BDT</span>
            </div>
            <input type="number" name="regular_price" class="form-control" id="regular_price">
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <label for="sale_price" class="text-dark mb-0">Sale Price <small class="text-danger">*</small></label>
        <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">BDT</span>
            </div>
            <input type="number" name="sale_price" class="form-control" id="sale_price" required>
        </div>
    </div>
    </div>
    <div class="col-12">
        <hr class="mt-0 mb-2">
    </div>
    <div class="col-12">
        <label for="meta_title" class="text-dark mb-0">Meta Title</label>
        <input type="text" name="meta_title" class="form-control mb-3" id="meta_title">
        <label for="meta_description" class="text-dark mb-0">Meta Description</label>
        <textarea name="meta_description" class="form-control" id="meta_description" rows="4"></textarea>
    </div>
    </div>
    <div class="col-12">
        <hr class="my-2">
    </div>
    <div class="col-12 mb-3">
    <div class="row">
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center mb-md-0 mb-3">
            <label for="images">Select product images <small class="text-danger">*</small></label>
            <input type="file" id="images" accept=".png, .jpg, .jpeg" multiple>
        </div>
        <div class="col-md-6">
            <input type="hidden" name="images" class="images-data">
            <ul class="list-group list-group-numbered image-previews">
            </ul>
        </div>
    </div>
    </div>
    <div class="col-12 text-center">
        <button type="submit" class="btn btn-outline-success">Publish Now</button>
    </div>
</div>
</form>
</div>
</div>
</div>
@endsection
@section("script")
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
$(document).ready(function() {
    $('#description').summernote({
        tabsize: 2,
        height: 250
    });

    let featuredArray = [];
    $('#add_featured_btn').click(function() {
        let value = $('#add_featured_field').val().trim();
        if (value) {
            featuredArray.push(value);
            let listItem = `<li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${value}</span>
                                <i class="fas fa-circle-minus text-danger cursor_pointer remove_featured"></i>
                            </li>`;
            $('#add_featured_ul').append(listItem);
            $('#add_featured_store_field').val(JSON.stringify(featuredArray));
            $('#add_featured_field').val('').focus();
        }
    });
    $(document).on('click', '.remove_featured', function() {
        let listItem = $(this).closest('li');
        let value = listItem.find('span').text();
        featuredArray = featuredArray.filter(function(item) {
            return item !== value;
        });
        listItem.remove();
        $('#add_featured_store_field').val(JSON.stringify(featuredArray));
    });

    $('.badge.cursor_pointer').click(function() {
        let badgeText = $(this).text().trim();
        $('#add_specification_field_key').val(badgeText);
    });
    let specificationArray = [];
    $('#add_specification_btn').click(function() {
        let key = $('#add_specification_field_key').val().trim();
        let value = $('#add_specification_field_value').val().trim();
        if (key && value) {
            specificationArray.push({key: key, value: value});
            let tableRow = `<tr>
                                <td>${key}</td>
                                <td>${value}</td>
                                <td><i class="fas fa-circle-minus text-danger cursor_pointer remove_specification"></i></td>
                            </tr>`;
            $('#add_specification_table tbody').append(tableRow);
            $('#add_specification_store_field').val(JSON.stringify(specificationArray));
            $('#add_specification_field_key').val('').focus();
            $('#add_specification_field_value').val('');
        }
    });
    $(document).on('click', '.remove_specification', function() {
        let tableRow = $(this).closest('tr');
        let key = tableRow.find('td:first').text();
        specificationArray = specificationArray.filter(item => item.key !== key);
        tableRow.remove();
        $('#add_specification_store_field').val(JSON.stringify(specificationArray));
    });

    $('#images').change(function() {
        let imageDataArray = [];
        $.each(this.files, function(index, file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                $('.image-previews').append('<li class="list-group-item d-flex justify-content-between align-items-center">' +
                    '<div><img src="' + event.target.result + '" class="product_images_preview rounded"></div>' +
                    '<i class="fas fa-circle-minus fa-lg text-danger cursor_pointer remove_image"></i>' +
                    '</li>');
                imageDataArray.push(event.target.result);
                $('.images-data').val(JSON.stringify(imageDataArray));
            };
            reader.readAsDataURL(file);
        });
    });
    $(document).on('click', '.remove_image', function() {
        let imageIndex = $(this).parent().index();
        let imageDataArray = JSON.parse($('.images-data').val() || '[]');
        imageDataArray.splice(imageIndex, 1);
        $('.images-data').val(JSON.stringify(imageDataArray));
        $(this).parent().remove();
    });

    let categories = {!! json_encode($categories->pluck('name', 'id')->toArray()) !!};
    let subCategories = {!! $sub_categories->groupBy('category_id')->map->pluck('name', 'id')->toJson() !!};
    $('#category').change(function() {
        let categoryId = $(this).val();
        let subCategoryOptions = '<option selected disabled>-- Select Sub-Category --</option>';
        if (subCategories.hasOwnProperty(categoryId)) {
            $.each(subCategories[categoryId], function(subCategoryId, subCategoryName) {
                subCategoryOptions += '<option value="' + subCategoryId + '">' + subCategoryName + '</option>';
            });
        }
        $('#sub_category').html(subCategoryOptions);
    });
    let initialCategoryId = $('#category').val();
    if (initialCategoryId) {
        $('#category').trigger('change');
    }
});
</script>
@endsection