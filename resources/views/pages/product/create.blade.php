@extends('layouts.master')

@section('title', 'Product')

@section('styles')

@stop

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SFVN</a></li>
                        <li class="breadcrumb-item active">Product</li>
                    </ol>
                </div>
                <h4 class="page-title">Product</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <form class="form-horizontal" id="productForm" action="{{route('submit.create-product')}}">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label validate-require" for="name">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate-require" id="name" name="name" placeholder="Product name...">
                            <span class="text-danger validate-require validate-text nameError" id="nameError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="category" class="col-sm-2 col-form-label validate-require">Category</label>
                        <div class="col-sm-10">
                            <select id="category" class="form-control validate-require" name="category">
                                @foreach ($categories as $category)
                                    <option value="{{$category->uuid}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger validate-require validate-text categoryError" id="categoryError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label validate-require" for="price">Price</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate-require" id="price" name="price">
                            <span class="text-danger validate-require validate-text priceError" id="priceError"></span>
                        </div>
                    </div>

                    {!! $form !!}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label validate-require" for="description">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control validate-require" id="description" name="description" rows="5"></textarea>
                            <span class="text-danger validate-require validate-text descriptionError" id="descriptionError"></span>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center pt-5">
                        <button type="submit" class="btn btn-primary">Add new</button>
                    </div>
                </form>
            </div> <!-- end card-box -->
        </div><!-- end col -->
    </div>
    <!-- end page title -->
@stop

@section('scripts')
<script>
    $('#productForm').submit(function(e) {
    e.preventDefault();
    const url =$(this).attr('action')
    submitFormById('productForm', url, function(response) {
        // addNewRowCat(response.category)
        // closeModal('createCatModal');
        clearFormById('productForm');
        location.reload();
    }, function(xhr, status, error) {
        if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            printErrorMsg(errors)
        } else {
            console.error(xhr.responseText);
        }
    });
});
</script>
@stop
