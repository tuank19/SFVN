@extends('layouts.master')

@section('title', 'Invoice')

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
                        <li class="breadcrumb-item active">Invoice</li>
                    </ol>
                </div>
                <h4 class="page-title">Invoice</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-md-12">
            <div class="card-box">

                <!-- Logo & title -->
                <div class="clearfix">
                    <div class="float-left">
                        <img src="/assets/images/logo-sfvn-new.jpg" alt="" height="20">
                    </div>
                    <div class="float-right">
                        <h4 class="m-0 d-print-none">Invoice</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-6 col-lg-6">
                        <h6>Billing Address</h6>
                        <address class="line-h-24">
                            {{$invoice->customer->name}}<br>
                            {{$ward->pre}} {{$ward->name}}, {{$district->pre}} {{$district->name}}, {{$city->name}}<br>

                            <abbr title="Phone">P:</abbr> {{$invoice->customer->phone}}
                        </address>
                    </div> <!-- end col -->
                    <div class="col-md-6 col-6 col-lg-6">
                        <div class="mt-3 float-right">
                            <p><strong>Invoice No. : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp; 000{{$invoice->id}}</span></p>
                            <p><strong>Order Date : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp; {{$invoice->order->order_date}}</span></p>
                            <p><strong>Order No. : </strong> <span class="float-right">{{$invoice->order->order_number}} </span></p>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->



                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table mt-4 table-centered">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 10%"> Category</th>
                                        <th>Item</th>
                                        <th style="width: 10%" class="text-center">Unit</th>
                                        <th style="width: 10%" class="text-center">Price</th>
                                        <th style="width: 10%" class="text-center">Quantity</th>
                                        <th style="width: 10%" class="text-right">Total</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                    <tr>
                                        <td>{{$key++}}</td>
                                        <td>
                                            <b>{{$product->category->name}}</b>
                                        </td>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->unit->attr_value}}</td>
                                        <td class="text-right">{{$product->price}}</td>
                                        <td class="text-right">{{$product->prodDetail->quantity}}</td>

                                        <td class="text-right">{{$product->prodDetail->price}}</td>


                                    </tr>
                                    @endforeach



                                </tbody>
                            </table>
                        </div> <!-- end table-responsive -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-md-6 col-6 col-lg-6">
                        <div class="clearfix pt-5">
                            <h6>Notes:</h6>

                            <small class="text-muted">
                                All accounts are to be paid within 7 days from receipt of
                                invoice. To be paid by cheque or credit card or direct payment
                                online. If account is not paid within 7 days the credits details
                                supplied as confirmation of work undertaken will be charged the
                                agreed quoted fee noted above.
                            </small>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-md-6 col-6 col-lg-6">
                        <div class="float-right pt-4">
                            <p><b>Sub-total:</b> <span class="float-right">${{$invoice->total_amount}} USD</span></p>
                            <p><b>Discount (0%):</b> <span class="float-right"> &nbsp;&nbsp;&nbsp; $0</span></p>
                            <h3>${{$invoice->total_amount}} USD</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

                <div class="mt-4 mb-1">
                    <div class="text-right d-print-none">
                        <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer mr-1"></i> Print</a>
                        <a href="/order/edit-{{$invoice->order->order_number}}" class="btn btn-info waves-effect waves-light">edit</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
@stop

@section('scripts')

@stop
