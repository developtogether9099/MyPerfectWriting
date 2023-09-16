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
        <h4 class="page-title mb-0">{{$writer->name}}'s Tasks</h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-id-badge mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.writers') }}"> {{ __('Writers') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page"> {{ $writer->name }}</li>
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
                                <th width="15%">{{ __('Title') }}</th>
                                <th width="7%">{{ __('Client') }}</th>
                                <th width="7%">{{ __('Service Type') }}</th>
                                <th width="7%">{{ __('Budget') }}</th>
                                <th width="7%">{{ __('Posted') }}</th>
                                <th width="7%">{{ __('Deadline') }}</th>
                                <th width="5%">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                            <tr>
                                <td>{{__($task->title)}}</td>
                                <td>
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('users')->where('id', $task->customer_id)->first();
                                    echo $c->name;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('services')->where('id', $task->service_id)->first();
                                    echo $c->name;
                                    ?>
                                </td>
								<td>
									@if($task->currency == 'usd')
									<i class="fa fa-dollar"></i>{{__($task->total)}}
									@else 
									<i class="fa fa-gbp"></i>{{__($task->total)}}
									@endif
									</td>
                                <td><span class="font-weight-bold">{{\Carbon\Carbon::parse($task->created_at)->isoFormat('Do MMM YYYY')}}</span></td>
                                <td><span class="font-weight-bold">{{\Carbon\Carbon::parse($task->dead_line)->isoFormat('Do MMM YYYY')}}</span></td>
                                <td>
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('order_statuses')->where('id', $task->order_status_id)->first();
                                    echo $c->name;
                                    ?>
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