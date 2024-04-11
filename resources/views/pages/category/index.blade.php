@extends('layouts.master')

@section('title', 'Category')

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
                        <li class="breadcrumb-item active">Category</li>
                    </ol>
                </div>
                <h4 class="page-title">Category</h4>
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
                        <button class="btn btn-outline-secondary d-flex justify-content-between align-items-center gap-1"
                            type="button" data-toggle="modal" data-target="#createCatModal" data-whatever="New category">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            New category
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tableCategory" class="table table-bordered dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $cat)
                              
                                <tr>
                                    <td>{{$cat->name}}</td>
                                    <td>{{$cat->parent->name}}</td>
                                    <td class="action-td">{!! $cat->action !!}</td>
                                </tr>
                            @endforeach
                           
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
    </div> <!-- end row -->
    <div class="modal fade" id="createCatModal" tabindex="-1" aria-labelledby="createCatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createCatForm" action="{{route('submit.create-category')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCatModalLabel">New category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 form-group form-group-validate ">
                            <label for="name" class="col-form-label validate-require">Name *</label>
                            <input onkeyup="updateSlug('name','slug')" type="text" class="form-control validate-require" id="name" name="name">
                            <span class="text-danger validate-require validate-text nameError" id="nameError"></span>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input id="isParent" name="isParent" type="checkbox" checked onchange="showParent(this,'parentCategorySelect')"> 
                                <label for="isParent">
                                    Is Parent Category?
                                </label>
                            </div>
                        </div>
                        <div class="form-group form-group-validate" id="parentCategorySelect" style="display: none;">
                            <label for="parentID" class="validate-require">Parent Category:</label>
                            <select class="form-control validate-require" id="parentID" name="parentID">
                                <option value="">Select Parent Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{$cat->uuid}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger validate-require validate-text parentIDError" id="parentIDError"></span>
                        </div>
                        <div class="mb-3 form-group form-group-validate">
                            <label for="slug" class="col-form-label validate-require">slug *</label>
                            <input type="text" class="form-control validate-require" id="slug" name="slug">
                            <span class="text-danger validate-require validate-text slugError" id="slugError"></span>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lưu và tạo mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editCatModal" tabindex="-1" aria-labelledby="editCatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editCatForm" method="POST">
                    @csrf
                    <input type="hidden" id="uuid" name="uuid" style="display: none">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCatModalLabel">Edit category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 form-group form-group-validate ">
                            <label for="nameEdit" class="col-form-label validate-require">Name *</label>
                            <input onkeyup="updateSlug('nameEdit','slugEdit')" type="text" class="form-control validate-require" id="nameEdit" name="nameEdit">
                            <span class="text-danger validate-require validate-text nameEditError" id="nameEditError"></span>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input id="isParentEdit" name="isParentEdit" type="checkbox" onchange="showParent(this,'parentCategorySelectEdit')">
                                <label for="isParentEdit">
                                    Is Parent Category?
                                </label>
                            </div>
                        </div>
                        <div class="form-group form-group-validate" id="parentCategorySelectEdit" style="display: none;">
                            <label for="parentID" class="validate-require">Parent Category:</label>
                            <select class="form-control validate-require" id="parentIDEdit" name="parentIDEdit">
                                <option value="">Select Parent Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{$cat->uuid}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger validate-require validate-text parentIDEditError" id="parentIDEditError"></span>
                        </div>
                        <div class="mb-3 form-group form-group-validate">
                            <label for="slugEdit" class="col-form-label validate-require">slug *</label>
                            <input type="text" class="form-control validate-require" id="slugEdit" name="slugEdit">
                            <span class="text-danger validate-require validate-text slugEditError" id="slugEditError"></span>
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
<script src="/assets/js/category.js"></script>
@stop
