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
            <h4 class="page-title mb-0">{{ __('Currency Rate') }}</h4>
        </div>
    </div>
    <!-- END PAGE HEADER -->
@endsection

@section('content')
    <form role="form" class="form-horizontal" enctype="multipart/form-data"
          action="{{ route('admin.update_currency_rates') }}" method="post" autocomplete="off">
        {{ csrf_field() }}

        <div class="row mt-3">
            <div class="form-group col-lg-5">
                <label for="pound">UK Pound <span class="required">*</span></label>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control" name="pound" id="pound" readonly
                           value="{{ $data->gb }}">
                    <i style="font-size:26px; margin-left:-30px" class="fas fa-pound-sign"></i>
                </div>
            </div>
            <div class="col-lg-2 mt-4 text-center">
                <h2>=</h2>
            </div>
            <div class="form-group col-lg-5">
                <label for="dollar">US Dollar <span class="required">*</span></label>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control" required name="dollar" id="dollar"
                           value="{{ $data->usd }}">
                    <i style="font-size:26px; margin-left:-30px" class="fas fa-dollar-sign"></i>
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
