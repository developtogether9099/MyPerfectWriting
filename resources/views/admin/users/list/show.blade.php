@extends('layouts.app')

@section('page-header')
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">{{ __('User Information') }}</h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-id-badge mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.user.dashboard') }}"> {{ __('User Management') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.user.list') }}">{{ __('User List') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#"> {{ __('View User Information') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection

@section('content')
	<!-- USER PROFILE PAGE -->
	<div class="row">
		<div class="col-xl-3 col-lg-3 col-md-12">
			<div class="card border-0">
				<div class="card-header">
					<h3 class="card-title">{{ __('Personal Information') }}</h3>
				</div>
				
				<div class="widget-user-image overflow-hidden mx-auto mt-5"><img alt="User Avatar" class="rounded-circle" src="@if($user->profile_photo_path) {{ $user->profile_photo_path }} @else {{ URL::asset('img/users/avatar.jpg') }} @endif"></div>
				<div class="card-body text-center">				
					<div>
						<h4 class="mb-1 mt-1 font-weight-bold fs-16">{{ $user->name }}</h4>
						<h6 class="text-muted fs-12">{{ $user->job_role }}</h6>
						
						
					</div>
				</div>
				
				<div class="card-body pt-0">
					<div class="table-responsive">
						<table class="table mb-0">
							<tbody>
								<tr>
									<td class="py-2 px-0 border-top-0">
										<span class="font-weight-semibold w-50">{{ __('Full Name') }} </span>
									</td>
									<td class="py-2 px-0 border-top-0">{{ $user->name }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Email') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->email }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('User Status') }} </span>
									</td>
									<td class="py-2 px-0">{{ ucfirst($user->status) }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('User Group') }} </span>
									</td>
									<td class="py-2 px-0">{{ ucfirst($user->group) }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Referral ID') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->referral_id }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Registered On') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->created_at }}</td>
								</tr>								
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Last Updated On') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->updated_at }}</td>
								</tr>								
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Job Role') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->job_role }}</td>
								</tr>								
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Company') }}</span>
									</td>
									<td class="py-2 px-0">{{ $user->company }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Website') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->website }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Address') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->address }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Postal Code') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->postal_code }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('City') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->city }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Country') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->country }}</td>
								</tr>								
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Phone') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->phone_number }}</td>
								</tr>
							</tbody>
						</table>
						<div class="border-0 text-right mb-2 mt-2">
							<a href="{{ route('admin.user.list') }}" class="btn btn-primary">{{ __('Return') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<!-- END USER PROFILE PAGE -->
@endsection

@section('js')
	<!-- Chart JS -->
	<script src="{{URL::asset('plugins/chart/chart.min.js')}}"></script>
	<script type="text/javascript">
		$(function() {
	
			'use strict';

			let usageData = JSON.parse(`<?php echo $chart_data['word_usage']; ?>`);
			let usageDataset = Object.values(usageData);
			let delayed;

			let ctx = document.getElementById('chart-user-usage');
			new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
					datasets: [{
						label: 'Words Generated',
						data: usageDataset,
						backgroundColor: '#007bff',
						borderWidth: 1,
						borderRadius: 20,
						barPercentage: 0.5,
						fill: true
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false,
						labels: {
							display: false
						}
					},
					responsive: true,
					animation: {
						onComplete: () => {
							delayed = true;
						},
						delay: (context) => {
							let delay = 0;
							if (context.type === 'data' && context.mode === 'default' && !delayed) {
								delay = context.dataIndex * 50 + context.datasetIndex * 5;
							}
							return delay;
						},
					},
					scales: {
						y: {
							stacked: true,
							ticks: {
								beginAtZero: true,
								font: {
									size: 10
								},
								stepSize: 2000,
							},
							grid: {
								color: '#ebecf1',
								borderDash: [3, 2]                            
							}
						},
						x: {
							stacked: true,
							ticks: {
								font: {
									size: 10
								}
							},
							grid: {
								color: '#ebecf1',
								borderDash: [3, 2]                            
							}
						},
					},
					plugins: {
						tooltip: {
							cornerRadius: 10,
							xPadding: 10,
							yPadding: 10,
							backgroundColor: '#000000',
							titleColor: '#FF9D00',
							yAlign: 'bottom',
							xAlign: 'center',
						},
						legend: {
							position: 'bottom',
							labels: {
								boxWidth: 10,
								font: {
									size: 10
								}
							}
						}
					}
					
				}
			});

		});
	</script>
@endsection
