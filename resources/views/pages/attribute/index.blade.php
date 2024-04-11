@extends('layouts.master')

@section('title', 'Category')

@section('styles')
<link rel="stylesheet" href="/assets/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/assets/css/bootstrap-tagsinput.css">

@stop

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SFVN</a></li>
                        <li class="breadcrumb-item active">Attribute</li>
                    </ol>
                </div>
                <h4 class="page-title">Attribute</h4>
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
                            type="button" data-toggle="modal" data-target="#createAttrModal" data-whatever="New category">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            New attribute
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
                            @foreach ($attrs as $attr)
                                <tr>
                                    <td>{{$attr->name}}</td>
                                    <td>{{$attr->input_type}}</td>
                                    <td class="action-td">{!! $attr->action !!}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
    </div> <!-- end row -->
    <div class="modal fade" id="createAttrModal" tabindex="-1" aria-labelledby="createAttrModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createAttrForm" action="{{route('submit.new-attribute')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAttrModalLabel">New attribute</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 form-group form-group-validate ">
                            <label for="name" class="col-form-label validate-require">Name *</label>
                            <input  type="text" class="form-control validate-require" id="name" name="name">
                            <span class="text-danger validate-require validate-text nameError" id="nameError"></span>
                        </div>
                        <div class="form-group form-group-validate">
                            <label for="inputType" class="validate-require">Input Type:</label>
                            <select class="form-control validate-require" id="inputType" name="inputType" onclick="selectInputType(event)">
                                <option value="text">Text</option>
                                <option value="select">Select</option>
                            </select>
                            <span class="text-danger validate-require validate-text parentIDError" id="parentIDError"></span>
                        </div>
                        <div class="form-group form-group-validate" id="selectOptionBlock" style="display: none">
                            <label for="selectOption" class="validate-require">Select Option:</label>
                            <select id="selectOption" name="selectOption[]" multiple data-role="tagsinput" class="form-control validate-require">
                            </select>
                            <span class="text-danger validate-require validate-text selectOptionError" id="selectOptionError"></span>
                        </div> <!-- end col -->
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
<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/bootstrap-tagsinput.min.js"></script>

<script>
let uuid = '';
function selectInputType() {
    const value = $('#inputType').val();

    const selectOptionBlock = document.getElementById('selectOptionBlock');

    if (value === 'select') {
        selectOptionBlock.style.display = 'block';
    } else {
        selectOptionBlock.style.display = 'none';
    }
}

$('#createAttrForm').submit(function(e) {
    e.preventDefault();
    const url =$(this).attr('action')
    submitFormById('createAttrForm', url, function(response) {
        // addNewRowCat(response.category)
        // closeModal('createAttrModal');
        clearFormById('createAttrForm');
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



$('#editAttrForm').submit(function(e) {
    e.preventDefault();
    const url =`/attrs/edit-${uuid}`
    submitFormById('editAttrForm', url, function(response) {
        clearFormById('editAttrForm');
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
