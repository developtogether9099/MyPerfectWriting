@extends('layouts.app')

@section('css')
<!-- Telephone Input CSS -->
<link href="{{URL::asset('plugins/telephoneinput/telephoneinput.css')}}" rel="stylesheet">
@endsection

@section('page-header')
<!-- EDIT PAGE HEADER -->
<div class="page-header mt-5-7">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">{{ __('Create Writer') }}</h4>
		<ol class="breadcrumb mb-2">
			<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-user-shield mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
			<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.writers') }}"> {{ __('Writers') }}</a></li>
		
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
				<h3 class="card-title">{{ __('Create Writer') }}</h3>
			</div>
			<div class="card-body pb-0">
				<form method="POST" action="{{ route('admin.writer_update', $writer->id) }}" enctype="multipart/form-data">
					@csrf

					<div class="row">
					
						<div class="col-sm-6 col-md-6">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12">{{ __('Username') }} <span class="text-muted">({{ __('Required') }})</span></label>
									<div class="d-flex align-items-center">
									<input type="text" class="form-control @error('username') is-danger @enderror" name="username" id="username" value="{{$writer->username}}" readOnly required>
									</div>
									@error('username')
											<p class="text-danger">{{ $errors->first('username') }}</p>
									@enderror
								</div>
							</div>
						</div>
						
						<div class="col-sm-6 col-md-6">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12">{{ __('Full Name ') }} <span class="text-muted">({{ __('Required') }})</span></label>
									<input type="text" value="{{$writer->name}}" class="form-control @error('name') is-danger @enderror" name="name" required>
									@error('name')
											<p class="text-danger">{{ $errors->first('name') }}</p>
									@enderror
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12">{{ __('Email ') }} <span class="text-muted">({{ __('Required') }})</span></label>
									<input type="email" value="{{$writer->email}}" class="form-control @error('email') is-danger @enderror" name="email" required>
									@error('email')
											<p class="text-danger">{{ $errors->first('email') }}</p>
									@enderror
								</div>
							</div>
						</div>
					
						<div class="col-sm-6 col-md-6">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12">{{ __('Write New Password') }} </label>
									<input type="text" class="form-control @error('password') is-danger @enderror" name="password" >
									@error('password')
											<p class="text-danger">{{ $errors->first('password') }}</p>
									@enderror
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label class="form-label fs-12">{{ __('Image') }} <span class="text-muted">({{ __('Required') }})</span></label>
								<input type="file" class="form-control @error('file') is-danger @enderror" name="file" >
									@error('file')
											<p class="text-danger">{{ $errors->first('file') }}</p>
									@enderror
							</div>
						</div>
						
					</div>

				
					<div class="card-footer border-0 text-right mb-2 pr-0">
						<a href="{{ route('admin.writers') }}" class="btn btn-cancel mr-2">{{ __('Return') }}</a>
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

<script>
$(document).ready(function() {
    // Handle click event
    $('#get-username').click(function() {
        // Make changes when clicked
        var i = '';

        $.ajax({
            url: '/get-writer-username',
            method: 'GET',
            success: function(response) {
                i = response; 
				$('#username').val(response)
                
            }
        });
    });
});
</script>
@endsection