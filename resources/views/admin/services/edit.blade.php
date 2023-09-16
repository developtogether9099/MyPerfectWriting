@extends('layouts.app')

@section('css')
<!-- Telephone Input CSS -->
<link href="{{URL::asset('plugins/telephoneinput/telephoneinput.css')}}" rel="stylesheet">
@endsection

@section('page-header')
<!-- EDIT PAGE HEADER -->
<div class="page-header mt-5-7">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">{{ __('Edit Service') }}</h4>
		<ol class="breadcrumb mb-2">
			<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-user-shield mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
			<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.services') }}"> {{ __('Services') }}</a></li>
		
		</ol>
	</div>
</div>
<!-- END PAGE HEADER -->
@endsection

@section('content')
<!-- EDIT USER PROFILE PAGE -->
<div class="row">
	<div class="col-xl-9 col-lg-8 col-sm-12">
		<div class="card border-0">
			<div class="card-header">
				<h3 class="card-title">{{ __('Edit Service') }}</h3>
			</div>
			<div class="card-body pb-0">
				<form method="POST" action="{{ route('admin.service_update') }}" enctype="multipart/form-data">
					@csrf

					<div class="row">
						<input type="hidden" name="id" value="{{$service->id}}">
						<div class="col-sm-6 col-md-9">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12">{{ __('Name ') }} <span class="text-muted">({{ __('Required') }})</span></label>
									<input type="text" class="form-control @error('name') is-danger @enderror" name="name" value="{{ $service->name }}" required>
									@error('name')
									<p class="text-danger">{{ $errors->first('name') }}</p>
									@enderror
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12">{{ __('Price ') }} <span class="text-muted">({{ __('Required') }})</span></label>
									<input type="text" class="form-control @error('price') is-danger @enderror" name="price" value="{{ $service->price }}" required>
									@error('price')
									<p class="text-danger">{{ $errors->first('price') }}</p>
									@enderror
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12">{{ __('Single Spacing Price') }} <span class="text-muted">({{ __('Required') }})</span></label>
									<input type="text" class="form-control @error('single_spacing_price') is-danger @enderror" name="single_spacing_price" value="{{$service->single_spacing_price}}" required>
									@error('single_spacing_price')
									<p class="text-danger">{{ $errors->first('single_spacing_price') }}</p>
									@enderror
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12">{{ __('Double Spacing Price') }} <span class="text-muted">({{ __('Required') }})</span></label>
									<input type="text" class="form-control @error('double_spacing_price') is-danger @enderror" name="double_spacing_price" value="{{$service->double_spacing_price}}" required>
									@error('double_spacing_price')
									<p class="text-danger">{{ $errors->first('double_spacing_price') }}</p>
									@enderror
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label class="form-label fs-12">{{ __('Minimum Order Quantity') }} <span class="text-muted">({{ __('Required') }})</span></label>
								<input type="number" class="form-control @error('minimum_order_quantity') is-danger @enderror" name="minimum_order_quantity" value="{{ $service->minimum_order_quantity}}" required>

								@error('minimum_order_qantity')
								<p class="text-danger">{{ $errors->first('minimum_order_quantity') }}</p>
								@enderror
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12">{{ __('Price Type') }} <span class="text-muted">({{ __('Required') }})</span></label>
									<select id="user-role" name="price_type_id" data-placeholder="{{ __('Select Price Type') }}" required>
										<option value="{{$price_type_selected->id}}" selected> {{ $price_type_selected->name }}</option>
										@foreach($price_type_others as $pt)
										<option value="{{$pt->id}}">{{ $pt->name }}</option>
										@endforeach
									</select>
									@error('price_type')
									<p class="text-danger">{{ $errors->first('price_type') }}</p>
									@enderror
								</div>
							</div>
						</div>
					</div>

					<div class="row border-top pt-4 mt-3">
						<div class="col-sm-12 col-md-12">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12">{{ __('Additional Services') }} <span class="text-muted">({{ __('Optional') }})</span></label>
									<input type="text" class="form-control @error('job_role') is-danger @enderror" name="job_role" value="{{ old('job_role') }}">
									@error('job_role')
									<p class="text-danger">{{ $errors->first('job_role') }}</p>
									@enderror
								</div>
							</div>
						</div>

					</div>
					<div class="card-footer border-0 text-right mb-2 pr-0">
						<a href="{{ route('admin.services') }}" class="btn btn-cancel mr-2">{{ __('Return') }}</a>
						<button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
					</div>
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
	$(function() {
		"use strict";

		$("#phone-number").intlTelInput();
	});
</script>
@endsection