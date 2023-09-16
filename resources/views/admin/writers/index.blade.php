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
        <h4 class="page-title mb-0">{{ __('All Writers') }}</h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-id-badge mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{ __('Writers List') }}</li>
        </ol>
    </div>
    <div class="page-rightheader">
		<a href="{{ route('admin.writer_create') }}" class="btn btn-primary mt-1">{{ __('Create New Writer') }}</a>
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
                                <th width="7%">{{ __('Username') }}</th>
                                <th width="12%">{{ __('Email') }}</th>
                                <th width="7%">{{ __('Tasks') }}</th>
                                <th width="5%">{{ __('Status') }}</th>
                                <th width="7%">{{ __('Created at') }}</th>
                                <th width="7%">{{ __('Actions') }}</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($writers as $writer)
                            <tr>
                                <td>{{$writer->username}}</td>
                                <td>{{$writer->email}}</td>
                                <td>
                                    <?php
                                    $no = Illuminate\Support\Facades\DB::table('orders')
                                        ->where('staff_id', $writer->id)
                                        ->count();
                                    ?>
                                    <a class="text-primary" href="{{route('admin.writer_tasks')}}?writer={{$writer->id}}"> <i class="fa fa-eye"> {{$no}}</i></a>
                                </td>
                                <td>
						
                                    @if($writer->status == 1)
                                    <a href="{{route('admin.writer_inactive')}}?writer={{$writer->id}}">
										<input type="checkbox" name="enable-gcp" class="custom-switch-input" checked>
                                        <span class="custom-switch-indicator"></span>
                                    </a>
                                    @else
                                    <a href="{{route('admin.writer_active')}}?writer={{$writer->id}}">

                                    <span class="custom-switch-indicator"></span>
                                    </a>
                                    @endif
                                </td>
                                <td>
									<span class="font-weight-bold">{{\Carbon\Carbon::parse($writer->created_at)->isoFormat('Do MMM YYYY')}}</span></td>
                    			<td>  
									<a href="{{route('admin.writer_edit', $writer->id)}}">
										<i class="fa fa-edit"></i>
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