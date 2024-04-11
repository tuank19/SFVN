@extends('layouts.master')

@section('title', 'Customer')

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
                        <li class="breadcrumb-item active">Customer</li>
                    </ol>
                </div>
                <h4 class="page-title">Customer</h4>
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
                        <button class="btn btn-outline-secondary d-flex justify-content-between align-items-center gap-1" type="button" data-toggle="modal" data-target="#addCustomerModal" data-whatever="New customer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            New customer
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tableCategory" class="table table-bordered dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th># No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $key => $customer)
                                <tr>
                                    <td style="width: 5%">{{$key+1}}</td>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->email}} $</td>
                                    <td>{{$customer->phone}}</td>
                                    <td class="action-td">
                                        <a href="/customer/edit-{{$customer->uuid}}">View</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
    </div> <!-- end row -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="createCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="createCustomerForm" action="{{route('submit.create-customer')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCustomerModal">New customer</h5>
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
<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/dataTables.bootstrap4.min.js"></script>
<script src="/assets/js/datatables.init.js"></script>
<script>
     $( document ).ready(function() {
        getCity();
     })

     $("#createCustomerForm").submit(function (e) {
        e.preventDefault();
        const url = $(this).attr("action");
        submitFormById(
            "createCustomerForm",
            url,
            function (response) {
                $("#addCustomerModal").modal("hide");
                location.reload();
            },
            function (xhr, status, error) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    printErrorMsg(errors);
                } else {
                    console.error(xhr.responseText);
                }
            }
        );
    });

</script>
@stop
