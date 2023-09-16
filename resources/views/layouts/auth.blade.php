<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<!-- Meta data -->
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="">
	    <meta name="keywords" content="">
	    <meta name="description" content="">
		
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>{{ config('app.name') }}</title>

		<!-- Style css -->
		<link href="{{URL::asset('plugins/tippy/scale-extreme.css')}}" rel="stylesheet" />
<link href="{{URL::asset('plugins/tippy/material.css')}}" rel="stylesheet" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400&display=swap" rel="stylesheet">

		@include('layouts.header')

	</head>

	<body class="app sidebar-mini">

		<!-- Page -->
		<div class="page">
			<div class="page-main">
				
				<!-- App-Content -->			
				<div class="main-content">
					<div class="side-app">

						@yield('content')

					</div>                   
				</div>
		
		</div><!-- End Page -->

		@include('layouts.footer-frontend')
        
	</body>
</html>


