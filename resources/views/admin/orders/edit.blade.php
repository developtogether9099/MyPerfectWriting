@extends('layouts.app')

@section('css')
<!-- Telephone Input CSS -->
<link href="{{URL::asset('plugins/telephoneinput/telephoneinput.css')}}" rel="stylesheet">
@endsection

@section('page-header')
<!-- EDIT PAGE HEADER -->
<div class="page-header mt-5-7">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">{{ __('Edit Order') }}</h4>
		<ol class="breadcrumb mb-2">
			<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-user-shield mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
			<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.orders') }}"> {{ __('Orders') }}</a></li>
		
		</ol>
	</div>
</div>
<!-- END PAGE HEADER -->
@endsection

@section('content')
<!-- EDIT USER PROFILE PAGE -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-sm-12">
		<div class="card border-0">
			
			<div class="card-body pb-0 p-3 rounded"  style="background-color: #3C3465; color: #ffffff;">
				<form method="POST" class="row" action="{{ route('admin.order_update', $order->id) }}" enctype="multipart/form-data">
					 
            @csrf
          
              <div class="col-md-6 mt-2">
                <div class="form-group">
					<label for="quantity">Services</label>
                  <select name="service_id" class="form-control" id="f-service" required>
                    <option value="{{$sservice->id}}">{{$sservice->name}}</option>
                    @foreach($services as $service)
                    <option value="{{$service->id}}">{{$service->name}}</option>
                    @endforeach

                  </select>
                  <div id="f-service-err" class="text-danger" style="display:none">This field is required</div>
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
					<label for="quantity">Education Level</label>
                  <select name="work_level_id" class="form-control" id="f-wl" required>
                     <option value="{{$swork_level->id}}">{{$swork_level->name}}</option>
                    @foreach($work_levels as $wl)
                    <option value="{{$wl->id}}">{{$wl->name}}</option>
                    @endforeach
                  </select>
                  <div id="f-wl-err" class="text-danger" style="display:none">This field is required</div>
                </div>
              </div>
              
              <div class="col-md-2 mt-2">
                <div class="form-group">
                  <label for="quantity">No. of pages</label>
                  
                    <input type="number" name="qty" class="form-control" id="quantity" value="{{$order->quantity}}" min="1" style="width:100%;">
                  
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="deadline-date">Deadline Date</label>
                  <input type="date" name="deadline_date" id="deadline-date" value="{{$order->dead_line}}" class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                </div>
              </div>

              <div class="col-md-2 mt-2">
                <div class="form-group">
                  <label for="deadline-time">Time</label>
                  <select name="deadline_time" id="deadline-time" class="form-control" required>
                    @php
                    $currentHour = date('H');
                    $currentMinute = (int) date('i');
                    $currentMinute = $currentMinute - ($currentMinute % 15); // Round down to the nearest 15 minutes
                    @endphp
                    @for ($hour = 0; $hour < 24; $hour++) @for ($minute=0; $minute < 60; $minute +=15) @php $optionValue=sprintf('%02d:%02d', $hour, $minute); $disabled=($hour < $currentHour || ($hour===$currentHour && $minute < $currentMinute)) ? 'disabled' : '' ; $selected=($hour===$currentHour && $minute===$currentMinute) ? 'selected' : '' ; @endphp <option value="{{ $optionValue }}" {{ $disabled }} {{ $selected }}>
                      {{ $optionValue }}
                      </option>
                      @endfor
                      @endfor
                  </select>
                </div>
              </div>

          

   <div class="col-md-6 mt-2">
                <div class="form-group">

                  <label for="f-course">Subjects</label>
                  <select name="course" id="f-course" class="form-control" required>
                     <option value="{{$ssubject->name}}">{{$ssubject->name}}</option>
                    @foreach($subjects as $subject)
                    <option value="{{$subject->name}}">{{$subject->name}}</option>
                    @endforeach

                  </select>
                </div>
              </div>

           
         
              
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="f-title">Title</label>
                  <input type="text" name="title" id="f-title" class="form-control" value="{{$order->title}}" placeholder="Title of your document" required>
                </div>
              </div>
           

           

              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="f-formatting">Citation Style</label>
                  <select name="formatting2" id="f-formatting" class="form-control" required>
                     <option value="{{$scitation->name}}">{{$scitation->name}}</option>
                    @foreach($citations as $citation)
                    <option value="{{$citation->name}}">{{$citation->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            


              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="file">Number of Sources</label>
                  <input type="text" name="sources" id="f-sources" class="form-control"  value="{{$order->sources}}" placeholder="Number of Sources" required>
                </div>
              </div>
				   <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="file">Attachments</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="file[]" class="custom-file-input" id="file" multiple>
                    </div>
                  </div>
                </div>

              </div>
              <div class="col-md-12 mt-2">
                <div class="form-group">
                  <label for="f-specifications">Description</label>
                  <textarea name="specifications" id="f-specifications" class="form-control" rows="3" style="height: 150px;" placeholder="Describe your task in detail or attach file with teacher’s instruction" required>{{$order->instruction}}</textarea>
                </div>
              </div>


           

              <div class="col-md-12 mt-2 row" style="padding-top: 50px;">

                   <label for="f-plan">Choose the Expert Level</label>
                <?php $i = 1; $o = 1; ?>
                @foreach($packages as $package)
                <div class="col-md-6">
                  <div class="card border-0 form-group py-2 plan{{$i++}}" style=" color: #000000; height:200px">
                    <input type="hidden" class="planType" name="planType" value="normal">
                    <h6 class="text-center" style="padding: 10px;">{{$package->name}}</h6>
                    <p class="text-center" style="padding: 5px;">{{$package->description}}</p>

                    @if($package->cost == 0)
                    <p class="text-center">No extra cost</p>
                    @else
                    <p class="text-center"><i class="fa {{format_amount(1)['icon']}}"></i><span id="premium-amount">{{format_amount($package->cost)['amount']}}</span></p>

                    @endif
					  @if($order->package_amount ==  format_amount($package->cost)['amount'] )
					  <a class="btn btn-primary select{{$o++}}" style="background: #1a1630 "> Selected </a>
					  @else 
					   <a class="btn btn-primary select{{$o++}}"> Select </a>
					  @endif
                  </div>
                </div>
                @endforeach

              </div>



            
              
					<button class="btn btn-primary btn-block">Update</button>


          </form>
			</div>
		</div>
	</div>
</div>
<!-- EDIT USER PROFILE PAGE -->
@endsection

@section('js')
<!-- Telephone Input JS -->
<script src="{{URL::asset('plugins/telephoneinput/telephoneinput.js')}}"></script>
<script>
	
	 $('.plan1').click(function() {
        var quantity = $('#quantity').val();
        var pp = $('#pp').val();
        var amount = pp * parseInt(quantity);

        amount = parseFloat(amount).toFixed(2)
        $('#sub_total').text(amount)
        $('.planType').val('normal');
        $('.plan1').css("border", "1px solid #0b5ed7");
        $('.plan2').css("border", "1px solid white");
        $(".plan2").css("pointer-events", "");
        $(".plan1").css("pointer-events", "none");
        $('.select2').css("background", "#f49d1d");
        $('.select1').css("background", "#1a1630");
        $('.select1').text("Selected");
        $('.select2').text("Select");

      });
      $('.plan2').click(function() {
        //var amo = $('#sub_total').text();
        var quantity = $('#quantity').val();
        var p_amo = $('#premium-amount').text();

        var total = parseFloat(quantity) * parseFloat(p_amo);

        total = parseFloat(total).toFixed(2)
        $('#sub_total').text(total)
        $('.planType').val('premium');
        $('.plan2').css("border", "1px solid #0b5ed7");
        $('.plan1').css("border", "1px solid white");
        $(".plan2").css("pointer-events", "none");
        $(".plan1").css("pointer-events", "");
        $('.select1').css("background", "#f49d1d");
        $('.select2').css("background", "#1a1630");
        $('.select2').text("Selected");
        $('.select1').text("Select");
      });
	$(function() {
		"use strict";

		$("#phone-number").intlTelInput();
	});
</script>
@endsection