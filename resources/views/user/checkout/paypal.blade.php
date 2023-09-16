@extends('layouts.app')

@section('page-header')
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">{{ __('Secure Checkout') }}</h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-box-circle-check mr-2 fs-12"></i>{{ __('User') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="{{ route('user.plans') }}"> {{ __('Pricing Plans') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="{{url('#')}}"> {{ __('One Time Payment Checkout') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection

@section('content')	
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
			<div class="card border-0 pt-2">
				<div class="card-body">	
					
					<form id="payment-form" action=""  method="POST" enctype="multipart/form-data">
						@csrf

						<div class="row">
							<div class="col-md-6 col-sm-12 pr-4">
								<div class="checkout-wrapper-box pb-0">									

										<p class="checkout-title mt-2"><i class="fa-solid fa-lock-hashtag text-success mr-2"></i>{{ __('Secure Checkout') }}</p>

										<div class="divider mb-5">
											<div class="divider-text text-muted">
												<small>{{ __('Select Payment Option') }}</small>
											</div>
										</div>

										<div class="form-group" id="toggler">					
													
											<div class="text-center">
												<div class="btn-group btn-group-toggle w-100" data-toggle='buttons'>
													<div class="row w-100">
																								
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">															
																	
			
															</div>										
												
													</div>							
												</div>
											</div>
											
										
										</div>

<div id="paypal-button-container"></div>
								</div>
							</div>

							<div class="col-md-6 col-sm-12 pl-4">
								<div class="checkout-wrapper-box">

									

									<div class="divider mb-4">
										<div class="divider-text text-muted">
											<small>{{ __('Purchase Summary') }}</small>
										</div>
									</div>
 
									<div>
										<p class="fs-12 p-family">{{ __('Subtotal') }} <span class="checkout-cost">${{$data['total']}}</span></p>
					
									</div>

									<div class="divider mb-5">
										<div class="divider-text text-muted">
											<small>{{ __('Total') }}</small>
										</div>
									</div>


									<div class="input-box mb-5">
										<div class="input-group">								
											<input type="text" class="form-control border-right-0 promocode-field" name="promo_code" placeholder="{{ __('Promocode') }}">
											<label class="input-group-btn">
												<a class="btn btn-primary" id="prepaid-promocode-apply">{{ __('Apply') }}</a>
											</label>											
										</div>
										<span id="promocode-error" class="d-none fs-12 text-danger"></span>
									</div>

									<div id="voucher-result" class="d-none">
										<p class="fs-12 p-family">{{ __('Discount Applied') }} <span class="checkout-cost"><span id="total_discount"></span></span></p>
									</div>
									
									<div>
										<p class="fs-12 p-family">{{ __('Total Payment') }} <span class="checkout-cost text-info">${{$data['total']}}</span></p>
									</div>

								

								</div>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>


</div>

@endsection



    

@section('js')
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                $('#paypalmsg').html('<b>' + 'WAITING ON AUTHORIZATION TO RETURN...' + '</b>');
                $('#chkoutmsg').hide()
                return actions.order.create({
                    purchase_units: [{
                        description: 'GnG Order',
                        amount: {
                            value: "{{$data['total']}}"
                        },
                   
                    }],
                    application_context: {
                        shipping_preference: 'NO_SHIPPING',
                      
                    }

                });
            },
            onApprove: function(data, actions) {
                // Replace 'YOUR_SERVER_ENDPOINT' with the Laravel route that executes the payment
                return fetch("{{route('paypal_process')}}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    },
                    body: JSON.stringify({
                        orderID: data.orderID
                    }),
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    window.location.href = data.redirect_url;
                });
            }
            
        }).render('#paypal-button-container');
    </script>
@endsection