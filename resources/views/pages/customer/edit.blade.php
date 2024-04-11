@extends('layouts.master')

@section('title', 'Customer')

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
                        <li class="breadcrumb-item active">Customer</li>
                    </ol>
                </div>
                <h4 class="page-title">Customer</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <form class="form-horizontal" id="customerForm" action="{{route('submit.edit-customer',['uuid'=>$customer->uuid])}}">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label validate-require" for="name">Name *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate-require" id="name" value="{{$customer->name}}" name="name" placeholder="Product name...">
                            <span class="text-danger validate-require validate-text nameError" id="nameError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label validate-require" for="email">Email *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate-require" id="email" name="email" value="{{$customer->email}}" placeholder="Product name...">
                            <span class="text-danger validate-require validate-text emailError" id="emailError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label validate-require" for="phone">Phone *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate-require" id="phone" name="phone" value="{{$customer->phone}}" placeholder="Product name...">
                            <span class="text-danger validate-require validate-text phoneError" id="phoneError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="city" class="col-sm-2 col-form-label validate-require">City *</label>
                        <div class="col-sm-10">
                            <select id="city" name="city" class="form-control validate-require" onchange="selectedCity()">
                                <option value="{{$cityCurrent->id}}" selected>{{$cityCurrent->name}}</option>
                                @foreach ($city as $cityItem)

                                    <option value="{{$cityItem->id}}">{{$cityItem->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger validate-require validate-text cityError" id="cityError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="district" class="col-sm-2 col-form-label validate-require">District *</label>
                        <div class="col-sm-10">
                            <select id="district" name="district" class="form-control validate-require" onchange="selectDistrict()">
                                <option value="{{$districtCurrent->id}}" selected>{{$districtCurrent->name}}</option>
                                @foreach ($district as $districtItem)

                                    <option value="{{$districtItem->id}}">{{$districtItem->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger validate-require validate-text districtError" id="districtError"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ward" class="col-sm-2 col-form-label validate-require">Ward *</label>
                        <div class="col-sm-10">

                                <select id="ward" name="ward" class="form-control validate-require">
                                    <option value="{{$wardCurrent->id}}" selected>{{$wardCurrent->name}}</option>
                                    @foreach ($ward as $wardItem)
                                        <option value="{{$wardItem->id}}">{{$wardItem->name}}</option>
                                    @endforeach
                                </select>

                            <span class="text-danger validate-require validate-text wardError" id="wardError"></span>
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
    $('#customerForm').submit(function(e) {
    e.preventDefault();
    const url =$(this).attr('action')
    submitFormById('customerForm', url, function(response) {
        // addNewRowCat(response.category)
        // closeModal('createCatModal');
        clearFormById('customerForm');
        window.location.href='/customer'
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
