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
        <h4 class="page-title mb-0">{{ __('Order Details') }}</h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-id-badge mr-2 fs-12"></i>{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('user.my_orders') }}">{{ __('Orders') }}</a></li>
        </ol>
    </div>

</div>
<!-- END PAGE HEADER -->
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-0">
                <h3> {{__($order->number)}}</h3>
                <div class="table-responsive">
                    <table class="table ">

                        <tbody>


                            <tr>
                                <th>@lang('Title')</th>
                                <td>
                                    {{__($order->title)}} <br>


                                </td>
                            </tr>

                            <tr>
                                <th>@lang('Budget')</th>
                                <td data-label="@lang('Referral Bonus')">
                                    @if($order->currency = 'usd')
									<i class="fa fa-dollar"></i>{{$order->total}}
									@else 
									<i class="fa fa-gbp"></i>{{$order->total}}
									@endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('Service Type')</th>
                                <td data-label="@lang('Referral Bonus')">
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('services')->where('id', $order->service_id)->first();
                                    echo $c->name;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Quantity</th>
                                <td>{{$order->quantity}} Pages</td>
                            </tr>
                      
                            <tr>
                                <th>@lang('Posted')</th>
                                <td data-label="@lang('Status')">
                                  <span class="font-weight-bold">{{date('Y-m-d h:i:A',strtotime($order->created_at))}}</span>
                                 
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('Deadline')</th>
                                <td data-label="@lang('Action')">
                                  <span class="font-weight-bold">{{date('Y-m-d h:i:A',strtotime($order->dead_line))}}</span>
                                 
                                </td>
                            </tr>
							 <tr>
                                <th>@lang('Client Files')</th>
                                <td data-label="@lang('Action')">
                                    <a href="{{$order->file_path}}" download>{{$order->file}}</a>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>@lang('Status')</th>
                                <td data-label="@lang('Action')">
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('order_statuses')->where('id', $order->order_status_id)->first();
                                    echo $c->name;
                                    ?>
                                </td>
                            </tr>
                          
                            <tr>
                                <th>@lang('Attachments')</th>
                                <td data-label="@lang('Action')">
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('submitted_works')->where('order_id', $order->id)->get();
                                    if ($c->count() > 0) {

                                        foreach ($c as $e) {
                                            # code...
                                            echo $e->display_name . '<br>';
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-6">
		  <div class="card">
            <div class="card-body p-2">
        <form action="{{route('admin.assign_submit')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="o_id" value="{{$order->id}}">
            <div class="form-group">
                <label for="">Select A Writer</label>
                <select name="writer_id" class="form-control">>
                    <option value="0">Select Writer</option>
                    @foreach($writers as $writer)
                    <option value="{{$writer->id}}">{{$writer->name}}</option>
                    @endforeach
                </select>
            </div>
			
			 <div class="form-group mt-3">
                <label for="">Deadline for Writer</label>
                <input type="datetime-local" class="form-control" name="writer_deadline" required>
            </div>
         
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary p-2 my-3">Assign</button>
            </div>
        </form>
            </div>
</div>
    </div>
</div>

@endsection