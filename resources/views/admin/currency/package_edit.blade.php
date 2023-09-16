@extends('layouts.app')

@section('css')
    <!-- Data Table CSS -->
    <link href="{{ asset('plugins/datatable/datatables.min.css') }}" rel="stylesheet">
    <!-- Sweet Alert CSS -->
    <link href="{{ asset('plugins/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">{{ __('Edit Package') }}</h4>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection

@section('content')
    <form role="form" class="form-horizontal container" enctype="multipart/form-data"
          action="{{ route('admin.package_update', $data->id) }}" method="post" autocomplete="off">
        {{ csrf_field() }}

        <div class="row mt-3">
            <div class="form-group col-lg-12">
                <label for="pound">Name <span class="required">*</span></label>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control" name="name" value="{{$data->name}}">
                </div>
            </div>
			 <div class="form-group col-lg-12">
                <label for="pound">Cost <span class="required">*</span></label>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control" name="cost" value="{{$data->cost}}">
                </div>
            </div>
           
            <div class="form-group col-lg-12">
                <label for="dollar">Description <span class="required">*</span></label>
                <div class="d-flex align-items-center">
					<textarea class="form-control" required name="description">{{$data->description}}</textarea>
                </div>
            </div>
            <div class="form-group col-lg-12 mt-3">
                <button class="btn btn-primary f-w-bold p-2 btn-block">Submit</button>
            </div>
        </div>
    </form>
@endsection

@section('innerPageJS')
    <script>
        $(function () {
            $('.selectPickerWithoutSearch').select2({
                theme: 'bootstrap4',
                minimumResultsForSearch: -1
            });
        });
    </script>
@endsection
