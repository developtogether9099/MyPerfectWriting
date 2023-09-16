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
            <h4 class="page-title mb-0">{{ __('Edit Work Level') }}</h4>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection

@section('content')
    <form role="form" class="form-horizontal container" enctype="multipart/form-data"
          action="{{ route('admin.work_level_update') }}" method="post" autocomplete="off">
        {{ csrf_field() }}

        <div class="row mt-3">
            <div class="form-group col-lg-12">
                <label for="pound">Name <span class="required">*</span></label>
                <div class="d-flex align-items-center">
					<input type="hidden" value="{{$work_level->id}}" name="id">
                    <input type="text" class="form-control" value="{{$work_level->name}}" name="name">
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
