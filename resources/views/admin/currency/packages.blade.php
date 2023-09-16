@extends('layouts.app')

@section('css')
<!-- Data Table CSS -->
<link href="{{URL::asset('plugins/datatable/datatables.min.css')}}" rel="stylesheet" />
<!-- Sweet Alert CSS -->
<link href="{{URL::asset('plugins/sweetalert/sweetalert2.min.css')}}" rel="stylesheet" />
@endsection

@section('page-header')
<!-- PAGE HEADER -->
<div class="page-header mt-5-7">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">{{ __('All Packages') }}</h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-id-badge mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{ __('Package List') }}</li>
        </ol>
    </div>

</div>
<!-- END PAGE HEADER -->
@endsection

@section('content')
<!-- USERS LIST DATA TABEL -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-xm-12">
        <div class="card border-0">

            <div class="card-body pt-2">
                <!-- BOX CONTENT -->
                <div class="box-content">

                    <!-- DATATABLE -->
                    <table id='listUsersTable' class='table listUsersTable' width='100%'>
                        <thead>
                            <tr>
                                <th width="7%">{{ __('Name') }}</th>
                                <th width="7%">{{ __('Cost') }}</th>
                                <th width="5%">{{ __('Status') }}</th>
                               <th width="5%">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                            <tr>
                                <td>
                                    {{$d->name}}
                                
                                </td>
                                <td>
                                   
                                    {{$d->cost}}
                                </td>
                                
                             
                                <td>
                                    @if($d->status == 1)
                                    <a href="{{route('admin.package_inactive')}}?package={{$d->id}}">

                                    	<input type="checkbox" name="enable-gcp" class="custom-switch-input" checked>
                                        <span class="custom-switch-indicator"></span>
                                    </a>
                                    @else
                                    <a href="{{route('admin.package_active')}}?package={{$d->id}}">

                                        <span class="custom-switch-indicator"></span>
                                    </a>
                                    @endif
                                </td>
                             
								     <td>
                                    
                                    <a href="{{route('admin.package_edit', $d->id)}}">
										edit
                                    </a>
                                   
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- END DATATABLE -->

                </div> <!-- END BOX CONTENT -->
            </div>
        </div>
    </div>
</div>
<!-- END USERS LIST DATA TABEL -->
@endsection