@extends('layouts.master')

@section('title', 'Edit order')

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
                        <li class="breadcrumb-item active">Order</li>
                    </ol>
                </div>
                <h4 class="page-title">Order</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card-box">

                <!-- Logo & title -->
                <div class="clearfix">
                    <div class="float-left">
                        <img src="/assets/images/logo-sfvn-new.jpg" alt="" height="20">
                    </div>
                    <div class="float-right">
                        <h4 class="m-0 d-print-none">Order</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-3">
                            <label><b>Customer: </b></label>
                            <select name="customer" id="customer" class="form-control validate-require" onchange="selectCustomer()">

                                @if ($customers->count() > 0)
                                    @foreach ($customers as $customer)
                                        <option value="{{$customer->uuid}}" @if($customer->uuid === $order->customer->uuid) selected @else ''  @endif>{{$customer->name}}</option>
                                    @endforeach
                                @endif

                                <option value="add-new">-- Add new customer-- </option>
                            </select>
                        </div>

                    </div><!-- end col -->
                    <div class="col-md-6">
                        <div class="mt-3 float-right">
                            <input type="hidden" name="orderDate">
                            <input type="hidden" name="orderStatus">
                            <input type="hidden" name="orderNumber">
                            <p><strong>Order Date : </strong><span class="float-right">&nbsp;&nbsp;&nbsp;&nbsp; {{$order->order_date}}</span></p>
                            <p><strong>Order Status : </strong> <span class="float-right"><span class="badge badge-danger">{{ $order->status }}</span></span></p>
                            <p><strong>Order No. : </strong> <span class="float-right">{{$order->order_number}} </span></p>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->

                <div class="row mt-3" id="billingAddress">
                    <div class="col-md-6">
                        <h6>Billing Address</h6>
                        <address class="line-h-24">
                            <span>Customer name: </span><span id="customerName">{{$order->customer->name}}</span><br>
                            <span>Ward </span><span id="wardBilling">{{$wardCurrent->name}}</span>,
                            <span>District </span><span id="districtBilling">{{$districtCurrent->name}}</span>,
                            <span>City </span><span id="cityBilling">{{$cityCurrent->name}}</span><br />
                            <span>Phone: </span><abbr title="Phone" id="phoneBilling">{{$order->customer->phone}}</abbr>
                        </address>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="mt-3">
                            <label><b>Category: </b></label>
                            <select name="category" id="category" class="form-control validate-require" onchange="selectCategory(this)">
                                <option>-- Select category ---</option>
                                @foreach ($cats as $cat)
                                    <option value="{{$cat->uuid}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-3" >
                            <label><b>Product: </b></label>
                            <select name="product" id="product" class="form-control validate-require">
                                <option>-- Select product ---</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mt-3" >
                            <label><b>Quantity: </b></label>
                            <input name="quantity" id="quantity" type="number" value="1" class="form-control validate-require">
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content-end align-items-end">
                        <button class="btn btn-outline-secondary waves-effect waves-light width-md" type="button" onclick="addProduct()">Add item</button>
                    </div>

                    <div id="prolist">

                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table mt-4 table-centered" id="tableProductItem">
                                <thead>
                                    <tr><th style="width: 5%">#</th>
                                        <th style="width: 10%"> Category</th>
                                        <th>Item</th>
                                        <th style="width: 10%" class="text-center">Unit</th>
                                        <th style="width: 10%" class="text-center">Price</th>
                                        <th style="width: 10%" class="text-center">Quantity</th>
                                        <th style="width: 10%" class="text-right">Total</th>
                                        <th style="width: 15%" class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-md-6">

                    </div> <!-- end col -->
                    <div class="col-md-6">
                        <div class="float-right pt-4">
                            <p><b>Sub-total:</b>$ <span class="float-right" id="subtotal">0</span></p>
                            <h3>$<span id="sum">0</span><span>USD</span></h3>
                        </div>
                        <div class="clearfix"></div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

                <div class="mt-4 mb-1">
                    <div class="text-right d-print-none">

                        <button type="button" onclick="submitData()" class="btn btn-info waves-effect waves-light">Submit</button>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="createCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="createCustomerForm" action="{{route('submit.create-customer')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCustomerModalLabel">New customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2 form-group form-group-validate ">
                                    <label for="name" class="col-form-label validate-require">Name *</label>
                                    <input type="text" class="form-control validate-require" id="name" name="name">
                                    <span class="text-danger validate-require validate-text nameError" id="nameError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2 form-group form-group-validate ">
                                    <label for="email" class="col-form-label validate-require">Email *</label>
                                    <input type="text" class="form-control validate-require" id="email" name="email">
                                    <span class="text-danger validate-require validate-text emailError" id="emailError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2 form-group form-group-validate ">
                                    <label for="phone" class="col-form-label validate-require">Phone *</label>
                                    <input type="text" class="form-control validate-require" id="phone" name="phone">
                                    <span class="text-danger validate-require validate-text phoneError" id="phoneError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2 form-group form-group-validate ">
                                    <label for="city" class="col-form-label validate-require">City *</label>
                                    <select id="city" name="city" class="form-control" onchange="selectedCity()">
                                        @foreach ($city as $cityItem)
                                            <option value="{{$cityItem->id}}">{{$cityItem->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger validate-require validate-text cityError" id="cityError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2 form-group form-group-validate ">
                                    <label for="district" class="col-form-label validate-require">District *</label>
                                    <select id="district" name="district" class="form-control" onchange="selectDistrict()">
                                    </select>
                                    <span class="text-danger validate-require validate-text districtError" id="districtError"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2 form-group form-group-validate ">
                                    <label for="ward" class="col-form-label validate-require">Ward *</label>
                                    <select id="ward" name="ward" class="form-control">
                                    </select>
                                    <span class="text-danger validate-require validate-text wardError" id="wardError"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lưu và tạo mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script src="/assets/js/order.js"></script>
<script>
    function submitData(){
        const orderDate = {!! json_encode($order->order_date) !!};
        const orderStatus = {!! json_encode($order->status) !!}
        const orderNumber = {!! json_encode($order->order_number) !!}
        const customerUUID = $("#customer").val();
        const data = JSON.stringify(productData);
        $.ajax({
            type: 'POST',
            url: `/order/edit-${orderNumber}`,
            data: {orderDate:orderDate,orderStatus:orderStatus, orderNumber:orderNumber, customerUUID:customerUUID, data:data },
            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
            success: function(response) {
                window.location.href = `/invoice/${response.invoice.id}`;
            },
            error: function(xhr, status, error) {
            }
        });
    }

    $( document ).ready(function() {
        productsByCat = {!! json_encode($dataProducts) !!};
        productData = {!! json_encode($products) !!};
        var productEntries = Object.entries(productData);
        productsByCat.forEach(function(entry) {
            displayProduct(entry)
        });

    });

</script>
@stop
