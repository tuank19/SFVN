@extends('layouts.master')

@section('title', 'Order')

@section('styles')
<link rel="stylesheet" href="/assets/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/css/responsive.bootstrap4.min.css">
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
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <input type="text" class="global_filter form-control" id="global_filter" placeholder="Search ...">
                        </div>
                        <a href="{{route('crate.order')}}" class="btn btn-outline-secondary d-flex justify-content-between align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            New order
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tableCategory" class="table table-bordered dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Customer</th>
                            <th>Total amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{$order->order_number}}</td>
                                    <td>{{$order->customer->name}}</td>
                                    <td>{{$order->invoice->total_amount}} $</td>
                                    <td>{{$order->status}}</td>
                                    <td class="action-td">{!! $order->action !!}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
    </div> <!-- end row -->


@stop

@section('scripts')
<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/js/datatables.init.js"></script>

@stop
