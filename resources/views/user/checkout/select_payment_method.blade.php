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

                <div class="row">
                    <div class="col-md-6 col-sm-12 pr-4">
                        <div class="checkout-wrapper-box pb-0">
							<h3 class="page-title">Personal Information</h3>
							
							 <table class="table ">

                        <tbody>


                            <tr>
                                <th>@lang('Name')</th>
                                <td>
                                    {{__(auth()->user()->name)}} <br>
								 </td>
                            </tr>
							<tr>
                                <th>@lang('Email')</th>
                                <td>
                                    {{__(auth()->user()->email)}} <br>
								 </td>
                            </tr>
							<tr>
                                <th>@lang('Username')</th>
                                <td>
                                    {{__(auth()->user()->username)}} <br>
								 </td>
                            </tr>
						</tbody>
                    </table>
							<br>
							<h3 class="page-title">Order Details</h3>
							<table class="table ">

                        <tbody>


                            <tr>
                                <th>@lang('Title')</th>
                                <td>
                                    


                                </td>
                            </tr>

                            <tr>
                                <th>@lang('Budget')</th>
                                <td data-label="@lang('Referral Bonus')">
									<i class="fa {{format_amount($order->total)['icon']}}"></i>
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('Service Type')</th>
                                <td data-label="@lang('Referral Bonus')">
                             
                                </td>
                            </tr>
                            <tr>
                                <th>Quantity</th>
                                <td> Pages</td>
                            </tr>
                            
                            <tr>
                                <th></th>
                                <td data-label="@lang('Benefit / Loss')">
                                    
                     
                                </td>
                            </tr>
                           
                            <tr>
                                <th>@lang('Posted')</th>
                                <td data-label="@lang('Status')">
                                 
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('Deadline')</th>
                                <td data-label="@lang('Action')">
                                 
                                </td>
                            </tr>

							<tr>
                                <th>@lang('My File')</th>
                                <td data-label="@lang('Action')">
                                    
                                </td>
                            </tr>
							
                        </tbody>
                    </table>

						</div> </div>
					<div class="col-md-6 col-sm-12 pr-4">
						
						<div class="checkout-wrapper-box">



                            <div class="divider mb-4">
                                <div class="divider-text text-muted">
                                    <small>{{ __('Purchase Summary') }}</small>
                                </div>
                            </div>

                            <div>
                                <p class="fs-12 p-family">{{ __('Subtotal') }} <span class="checkout-cost"></span></p>

                            </div>

                            <div class="divider mb-5">
                                <div class="divider-text text-muted">
                                    <small>{{ __('Total') }}</small>
                                </div>
                            </div>


                            <div class="input-box mb-5">
                                <div class="input-group">
                                    <input type="text" class="form-control border-right-0 promocode-field" name="promo_code" id="promo_code" placeholder="{{ __('Promocode') }}">
                                    <label class="input-group-btn">
                                        <a class="btn btn-primary" id="apply-promo">{{ __('Apply') }}</a>
                                    </label>
                                </div>
                                <span id="promocode-error" class="d-none fs-12 text-danger"></span>
                            </div>

                            <div id="voucher-result" class="d-none">
                                <p class="fs-12 p-family">{{ __('Discount Applied') }} <span class="checkout-cost"><span id="total_discount"></span></span></p>
                            </div>

                            <div>
                                <p class="fs-12 p-family">{{ __('Total Payment') }}<span class="checkout-cost text-info" id="gtotal"></span></p>
                            </div>



                        </div>
           
						
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

                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"> <label class="gateway btn rounded p-0" data-bs-toggle="collapse">

                                                    <a onclick="showform()" data-bs-toggle="modal" data-bs-target="#exampleModal2"  class="gateway btn rounded p-0" href="#"><img src="{{ URL::asset('img/payments/stripe.svg') }}"></a>
                                                </label>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12"> <label class="gateway btn rounded p-0" data-bs-toggle="collapse">

                                                    <a onclick="showform2()" data-bs-toggle="modal" data-bs-target="#exampleModal" id-"paypall" class="gateway btn rounded p-0" href="#"><img src="{{ URL::asset('img/payments/paypal.svg') }}"></a>
												
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                   
                            <div class="text-center" id="loading">Please wait ...</div>
                            
                        </div>
               
                                 </div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">PayPal Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div id="paypal-button-container" ></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
   
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Stripe Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form id='payment-form' style="display: none;">
                                <div class="mb-3">
                                    <label for="card-element">Card</label>
                                    <div id="card-element"></div>
                                    <div id="card-errors" class="invalid-feedback d-block"></div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block confirm-button pl-6 pr-6 mb-1" disabled>Checkout Now </button>
                            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
     
      </div>
    </div>
  </div>
</div>



<div id="publishable_key" data-publishablekey="{{ env('STRIPE_KEY')}}"></div>
<div id="process_url" data-processurl="{{ route('stripe_process') }}"></div>
@endsection 


@section('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="https://js.stripe.com/v3/"></script>
<script>
   function showform() {
        document.getElementById('payment-form').style.display = "block";
        document.getElementById('paypal-button-container').style.display = "none";
    }
	
	 function showform2() {
        document.getElementById('payment-form').style.display = "none";
        document.getElementById('paypal-button-container').style.display = "block";
    }

    document.addEventListener("DOMContentLoaded", function(event) {

        var publishableKey = document.getElementById('publishable_key').dataset.publishablekey;
        var process_url = document.getElementById('process_url').dataset.processurl;

        document.getElementById('loading').style.display = "none";

        var stripe = Stripe(publishableKey);

        var elements = stripe.elements();

        // Set up Stripe.js and Elements to use in checkout form
        var style = {
            base: {
                color: "#32325d",
                fontFamily: '"Nunito", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            },
        };

        var cardElement = elements.create('card', {
            hidePostalCode: true,
            style: style
        });
        cardElement.mount('#card-element');

        disableConfirmButton();

        displayError = document.getElementById('card-errors');

        // Handle real-time validation errors from the card Element.
        cardElement.on('change', function(event) {

            if (event.complete) {
                // enable payment button
                enableConfirmButton();
            } else if (event.error) {
                // show validation to customer
                displayError.textContent = event.error.message;
                disableConfirmButton();
            } else {
                displayError.textContent = '';
                enableConfirmButton();
            }

        });

        // Step: 1 Handle the Button Click
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            // Disable the confirm button    
            disableConfirmButton();

            stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
            }).then(stripePaymentMethodHandler);
        });

        // Step: 1 attempt to send paymentMethod.id to server
        function stripePaymentMethodHandler(result) {

            if (result.error) {
                if (result.error.hasOwnProperty('message')) {
                    showError(result.error.message);
                } else {
                    showError(result.error);
                }

                enableConfirmButton();
            } else {
                // Otherwise send paymentMethod.id to your server
                $("#loading").show();
                axios.post(process_url, {
                        payment_method_id: result.paymentMethod.id,
                    })
                    .then(function(response) {
                        $("#loading").hide();
                        handleServerResponse(response.data);
                    })
                    .catch(function(error) {
                        $("#loading").hide();
                        enableConfirmButton();
                    });


            }
        }


        function handleServerResponse(response) {
            if (response.error) {
                console.log(response.error);
                // Show error from server on payment form
                showError(response.error);
                enableConfirmButton();

            } else if (response.requires_action) {
                // Use Stripe.js to handle required card action
                disableConfirmButton();
                stripe.handleCardAction(
                    response.payment_intent_client_secret
                ).then(handleStripeJsResult);
            } else {
                // Show success message
                if (response.success) {
                    console.log(response)
                    //alert(1000);
                    window.location.href = response.redirect_url;
                }
            }
        }

        function handleStripeJsResult(result) {
            if (result.error) {
                // Show error in payment form
                showError(result.error.message);
                enableConfirmButton();
            } else {
                // The card action has been handled
                // The PaymentIntent can be confirmed again on the server
                disableConfirmButton();
                axios.post(process_url, {
                        payment_intent_id: result.paymentIntent.id
                    })
                    .then(function(response) {
                        handleServerResponse(response.data);
                    })
                    .catch(function(error) {
                        showError('Could not process your payment. Please try again.');
                        enableConfirmButton();
                    });



            }
        }

        function disableConfirmButton() {
            document.getElementsByClassName('confirm-button')[0].disabled = true;
        }

        function enableConfirmButton() {
            document.getElementsByClassName('confirm-button')[0].disabled = false;
        }

        function showError(message) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                text: message
            });
        }


    }); // End of script
</script>

<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
   
        document.getElementById('payment-form').style.display = "none";
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

<script>
$('#apply-promo').click(function(){
	var promo_code = $('#promo_code').val();
	$.ajax({
		type:'POST',
		url:"{{ route('user.apply_promo',$order->id) }}",
		data:{
			"_token":"{{ csrf_token() }}",
			"promo_code":promo_code
		},
		success:function(data){
			if(data.error != null) {
				$('#promocode-error').removeClass('d-none');
				$('#promocode-error').text(data.error)
			} else {
				$('#voucher-result').removeClass('d-none');
				$('#total_discount').text(data.discount)
				$('#gtotal').text('$'+data.total)
			}
			
		}
	});

});
</script>
@endsection