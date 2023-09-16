@extends('layouts.app')

@section('css')
<!-- Data Table CSS -->
<link href="{{URL::asset('plugins/datatable/datatables.min.css')}}" rel="stylesheet" />
<!-- Sweet Alert CSS -->
<link href="{{URL::asset('plugins/sweetalert/sweetalert2.min.css')}}" rel="stylesheet" />
<style>


label span input {
    z-index: 999;
    line-height: 0;
    font-size: 50px;
    position: absolute;
    top: -2px;
    left: -700px;
    opacity: 0;
    filter: alpha(opacity = 0);
    -ms-filter: "alpha(opacity=0)";
    cursor: pointer;
    _cursor: hand;
    margin: 0;
    padding:0;
}
</style>
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
									<?php $files = Illuminate\Support\Facades\DB::table('attachments')->where('order_id', $order->id)
									->where('uploader_id', $order->customer_id)->get(); ?>
									@foreach($files as $file)
                                    <a href="{{$file->file_path}}" download class="text-primary"><i class="fa fa-download"></i> {{$file->file}}</a> <br>
									@endforeach
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
                                <th>@lang('Revision Requested')</th>
                                <td data-label="@lang('Action')">
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('submitted_works')
                                        ->where('order_id', $order->id)
                                        ->where('needs_revision', '<>', null)
                                        ->first();
                                    if ($c)
                                        echo $c->needs_revision;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('Attachments')</th>
                                <td data-label="@lang('Action')">
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('attachments')->where('uploader_id', 1)->where('order_id', $order->id)->get();
                                    if ($c->count() > 0) {

                                       foreach ($c as $e) {?>

                                           <a href="{{$e->file_path}}" download>{{$e->file}}</a><br>

                                            <?php  }

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
	@if( $order->order_status_id != 5)
    
        <form action="{{route('admin.submit_work')}}" method="post" enctype="multipart/form-data">
			<h4>Submit Task to Client</h4>
            @csrf
             <input type="hidden" name="id" value="{{ $order->id }}">
            <div class="form-group">
                <label for="">Message</label>
                <textarea name="message" class="form-control" placeholder="Your Message"></textarea>
            </div>
            <div class="form-group">
                <label for="">File</label>
                <input type="file" name="name[]" class="form-control" multiple>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success my-3">Submit</button>
            </div>
        </form>
@endif

		@if( $order->payment_status == 1)

	
	 <div class="card border-0" style="background-color: #3C3465;">
      <div class="card-body pt-2">
        <div class="box-content" style="color: #ffffff;">
          <div class=" text-white ">
	


				
					<div class="row" >	
						<div class="p-4" id="support-messages-box" style="height:60vh; overflow:scroll; overflow-x:hidden">
@foreach($conversations as $conv)
							<?php $w = Illuminate\Support\Facades\DB::table('users')->where('username', $conv->sender)->first(); ?>
							@if($conv->sender != 'admin')
						<div class="background-white support-message mb-5">
					<p class="font-weight-bold text-primary fs-11"><i class="fa-sharp fa-solid fa-calendar-clock mr-2"></i>{{ date('Y-m-d h:i:A', strtotime($conv->created_at)) }} MPW</p>
						<p class="fs-14 text-dark mb-1">{{ $conv->message }}</p>@if ($conv->attachment != null)

											<p class="font-weight-bold fs-11 text-primary mb-1">{{ __('Attachment') }}</p>

											<a class="font-weight-bold fs-11 text-primary" download href="{{ $conv->attachment_path }}">{{ $conv->attachment }}</a>

										@endif

					
																		
						</div>
						@else
								<div class="background-white support-message support-response mb-5">
										<p class="font-weight-bold text-primary fs-11"><i class="fa-sharp fa-solid fa-calendar-clock mr-2"></i>{{ date('Y-m-d h:i:A', strtotime($conv->created_at)) }} <span>{{ __('Your Message') }}</span></p>
										
										<p class="fs-14 text-dark mb-1">{{ $conv->message }}</p>

										

											

		
										@if ($conv->attachment != null)
											<p class="font-weight-bold fs-11 text-primary mb-1">{{ __('Attachment') }}</p>
											<a class="font-weight-bold fs-11 text-primary" download href="{{ $conv->attachment_path }}">{{ $conv->attachment }}</a>
										@endif
									</div>
							@endif
							@endforeach
									
							
								
						
									
								
												
						</div>
					<form action="{{ route('admin.admin_send_message') }}" method="post" enctype="multipart/form-data">	
						@csrf
					<div class="input-box d-flex">
						<input type="hidden" name="o_id" value="{{$order->id}}">
						<input type="hidden" name="receiver_id" value="{{$order->staff_id}}">
					
					 
						
        
          	<textarea class="form-control"  style="border-radius:10px 0 0 10px !important; " name="message" placeholder="Enter your reply message here..."></textarea>
								  <label class="filebutton">
              <i class="fas fa-paperclip color-dark" style="margin-left:-26px; margin-top:20px; color:black"></i>
									  	<span><input type="file" id="myfile" name="myfile"></span>
								  </label>
         
              <button class="btn btn-primary" style="border-radius:0 10px 10px 0 !important; "><i class="fas fa-paper-plane"></i></button>
         
					</div>
					</form>
	
		</div>


	
    </div>
</div>
    </div>
				
</div>
			</div>
	@endif

</div>

@endsection