@extends('layouts.app')
@section('css')
<!-- Sweet Alert CSS -->
<link href="{{URL::asset('plugins/sweetalert/sweetalert2.min.css')}}" rel="stylesheet" />
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
<style>
 

  body {
    font-size: 13px;
  }

  .progress {
    height: 30px;
    margin-bottom: 20px;
  }

  .progress-bar {
    background-color: #f49d1d;
    border-radius: 0.5rem;
  }

  .error-tooltip {
    color: #dc3545;
    font-size: 12px;
    margin-top: 4px;
  }

 .loading-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.loading-spinner {
  display: inline-block;
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}


</style>
@section('page-header')
<!-- PAGE HEADER -->
<div class="page-header mt-5-7">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">{{ __('Review Order Details') }}</h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('user.unpaid_orders') }}"> {{ __('Unpaid Orders') }}</a></li>
        </ol>
    </div>
</div>
<!-- END PAGE HEADER -->
@endsection

@section('content')


                
<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-8">
                  <div class="card border-0" style="background: #3C3465; color: #ffffff !important">
					  <div class="card-body pt-2">
						          <div class="box-content" style="color: #ffffff;">
              <div class=" text-white " >

                <h3 class="page-title">Personal Information</h3>
                <p>Name<span class="float-right">

                    {{__(auth()->user()->name)}}
                  </span>
                </p>
                <p>
                  Email
                  <span class="float-right">
                    {{__(auth()->user()->email)}}
                  </span>
                </p>
                <p>
                  Username
                  <span class="float-right">
                    {{__(auth()->user()->username)}}
                  </span>
                </p>

                <br>
                <h3 class="page-title">Order Details</h3>
                <p>
                  Title
                  <span class="float-right" id="btitle"> {{$order->title}} </span>
                </p>

                <p>
                  Amount
                  <span class="float-right"><i class="fa {{format_amount(1)['icon']}}"></i><span id="btotal">{{$order->total}}</span> </span>
                </p>
                <p>
                  Service Type
                  <span class="float-right" id="bservice"> {{$sservice->name}}</span>
                </p>
                <p>
                  Education Level
                  <span class="float-right" id="bwork_level"> {{$swork_level->name}}</span>
                </p>
                <p>
                  Writer Level
                  <span class="float-right" id="bplan_type">{{$order->package}} </span>
                </p>
                <p>
                  Quantity
                  <span class="float-right"> <span id="bqty"></span>{{$order->quantity}} Pages</span>
                </p>
                <p>
                  Instruction
                  <span class="float-right" id="binstruction"> {{$order->instruction}}</span>
                </p>
                <p>
                  Citation
                  <span class="float-right" id="bformatting">{{$order->formatting}} </span>
                </p>
                <p>
                  Course
                  <span class="float-right" id="bcourse"> {{$order->course}}</span>
                </p>
                <p>
                  Sources
                  <span class="float-right" id="bsources"> {{$order->sources}}</span>
                </p>
                <p>
                  Posted On
                  <span class="float-right" id="bposted">{{date('Y-m-d',strtotime($order->created_at))}} </span>
                </p>
                <p>
                  Deadline Date
                  <span class="float-right" id="bdeadline_date"> {{$order->dead_line}}</span>
                </p>
                <p>
                  Deadline Time
                  <span class="float-right" id="bdeadline_time">{{$order->deadline_time}} </span>
                </p>
                <p>
                  My File
                   
					@if($order->file != null)
				   <a id="file_path" href="{{$order->file_path}}" class="float-right text-white"><i class="fa fa-download"></i> </a>
					<span class="float-right mr-2" id="file_name">{{$order->file}}</span> 
					@else 
					<span class="float-right">no file uploaded</span> 
					@endif
                </p>




              </div></div></div></div>
					</div>
<div class="col-lg-4 col-sm-8 col-md-8">
    <div class="card border-0" style="background-color: #3C3465;">

      <div class="card-body pt-2">



        <div class="box-content" style="color: #ffffff !important;">
          <div class="col-md-12 col-sm-12 pr-4">


            <div class="divider mb-4">
              <div class="divider-text text-muted" style="color: #ffffff !important;">
                <small>{{ __('Purchase Summary') }}</small>
              </div>
            </div>

            <div>
              <p class="fs-12 p-family">{{ __('Subtotal') }} <span class="checkout-cost"> <i class="fa {{format_amount(1)['icon']}}"></i><span id="sub_total">{{$order->total}}</span></span></p>

            </div>

            <div class="divider mb-5">
              <div class="divider-text text-muted" style="color: #ffffff !important;">
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
              <p class="fs-12 p-family">{{ __('Discount Applied') }} <span class="checkout-cost"> <i class="fa {{format_amount(1)['icon']}}"></i> <span id="total_discount"></span></span></p>
            </div>

            <div>
              <p class="fs-12 p-family">{{ __('Total Payment') }} <span class="checkout-cost"> <i class="fa {{format_amount(1)['icon']}}"></i> <span class="text-info" id="gtotal" style="color: #ffffff !important;">{{$order->total}}</span></span></p>
            </div>




            <button type="button" class="btn btn-primary" id="checkout"  style="width: 100%;" data-bs-toggle="modal" data-bs-target="#exampleModal2">Checkout</button>
            <br>
            <div class="divider mb-4">
              <div class="divider-text text-muted" style="color: #ffffff !important;">
                <small>{{ __('Secure Checkout') }}</small>
              </div>
            </div>
            <div>
              <img src="{{ URL::asset('img/payments/secure.png') }}" style="background-color: #ffffff; border-radius: 0.5rem;">
            </div>



            <div id="code" style="display: none;">
              <div class="pb-0">
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
                          <label class="gateway btn rounded p-0" data-bs-toggle="collapse">
                            <a onclick="showform()" data-bs-toggle="modal" data-bs-target="#exampleModal2" class="gateway btn rounded p-0" href="#">
                              <img src="{{ URL::asset('img/payments/stripe.svg') }}">
                            </a>
                          </label>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                          <label class="gateway btn rounded p-0" data-bs-toggle="collapse">
                            <a onclick="showform2()" data-bs-toggle="modal" data-bs-target="#exampleModal" id="paypall" class="gateway btn rounded p-0" href="#">
                              <img src="{{ URL::asset('img/payments/paypal.svg') }}">
                            </a>
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

  </div>



  <!-- PayPal Modal -->
  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="backdrop-filter: blur(5px);">

    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px; border-radius: 0.5rem;">
        <div class="modal-body text-center">
          <h3 style="padding: 10px;"><strong>Convenient Payment Options: Select Your Preferred Method</strong></h3>
          <h5>Please review your order details below and proceed to secure payment to complete your purchase.</h5>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="card border-0" style="background-color: #3C3465; color: #ffffff;">
                <div class="card-body">
                  <h5 class="card-title">Payment Method</h5>
                  <!-- Payment Gateway Selection -->
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentOption" id="paypalOption" value="paypal">
                    <label class="form-check-label" for="paypalOption">
                      PayPal
                    </label>
                    <img src="{{ URL::asset('img/payments/paypal.svg') }}" alt="PayPal Logo" style="float: right; width: 38%;">
                  </div>

                  <!-- PayPal payment form -->
                  <form id="paypal-form" style="display: none;">
                    <div class="row" style="width: 100%;">
					
                      <div id="paypal-button-container"></div>
						
                    </div>
                  </form>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentOption" id="stripeOption" value="stripe" checked>
                    <label class="form-check-label" for="stripeOption">
                      Credit or debit card
                    </label>
                    <img src="{{ URL::asset('img/payments/credit.png') }}" alt="Stripe" style="float: right; width: 38%;">
                  </div>

                  <form id="stripe-form" style="display: block;">
                    <div class="mb-3">
                      <label for="card-element">Card</label>
                      <div id="card-element"></div>
                      <div id="card-errors" class="invalid-feedback d-block"></div>
                      <p>
                        <i class="fas fa-lock-alt"></i>
                        Your transaction is secured with SSL encryption.
                      </p>
                    </div>
                 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <!-- Payment Summary -->
              <div class="card border-0" style="background-color: #3C3465; color: #ffffff;">
                <div class="card-body">
                  <h5 class="card-title">Summary</h5>
                  <div class="card-text">
                    <p class="fs-12 p-family">Order ID: <span class="checkout-cost"><span id="o_id">{{$order->id}}</span></span></p>
                    <p class="fs-12 p-family">Pages: <span class="checkout-cost"><span id="pages">{{$order->quantity}}</span></span></p>
                    <p class="fs-12 p-family">Deadline: <span class="checkout-cost"><span id="dl">{{$order->dead_line}}</span></span></p>
                    <p class="fs-12 p-family">Education Level: <span class="checkout-cost"><span id="el">{{$swork_level->name}}</span></span></p>
                    <p class="fs-12 p-family">Subtotal: <span class="checkout-cost"><i class="fa {{format_amount(1)['icon']}}"></i><span id="sub_total2">{{$order->total}}</span></span></p>
                    <p id="discount" style="display:none" class="fs-12 p-family">Discount Applied: <span class="checkout-cost"><i class="fa {{format_amount(1)['icon']}}"></i><span id="discount_amount">0</span></span></p>
                    <p class="fs-12 p-family" style="color: #ffffff;">Total Payment: <span class="checkout-cost"><i class="fa {{format_amount(1)['icon']}}"></i><span class="text-info" id="gtotal2">{{$order->total}}</span></span></p>
                  </div>
                  <br>
                  <button id="checkoutButton" type="submit" class="btn btn-primary btn-lg btn-block confirm-button pl-6 pr-6 mb-1" style="width: 100%" disabled>Checkout Now</button>
                </div>
              </div>
            </div>
				 </form>
            <div class="col-md-6">
              <!-- Additional Column -->
            </div>
          </div>
        </div>
      </div>
    </div>



            </div>
 
 <form id="payment-form" method="POST" action="{{ route('paypal_checkout_process') }}">
    @csrf
    <input id="order_id" name="order_id" type="hidden" />
  </form>

  <div id="publishable_key" data-publishablekey="{{ env('STRIPE_KEY')}}"></div>
  <div id="process_url" data-processurl="{{ route('stripe_process') }}"></div>


@endsection 


@section('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="https://js.stripe.com/v3/"></script>
<script>

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
        var form = document.getElementById('stripe-form');
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

<script>
	
var o = "{{$data['total']}}";
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
				$('#promocode-error').addClass('d-none');
				$('#voucher-result').removeClass('d-none');
				$('#total_discount').text(data.discount)
				$('#gtotal').text('$'+data.total)
				$('#gtotal2').text(data.total)
            	$('#discount').show()
            	$('#discount_amount').text(data.discount)
				o = data.total
			}
			
		}
	});

});
</script>


<script src="https://www.paypal.com/sdk/js?currency={{currency()}}&client-id={{ env('PAYPAL_CLIENT_ID') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function(event) {

    if (window.hasOwnProperty("paypal")) {
      paypal.Buttons({

        createOrder: function(data, actions) {
          return axios.post("{{ route('paypal_checkout_generate_token') }}")
            .then(function(response) {
              if (response.data.status == 'success') {
				 
                     return actions.order.create({
          purchase_units: [{
            description: 'GnG Order',
            amount: {
              value: 10
            },

          }],
          application_context: {
            shipping_preference: 'NO_SHIPPING',

          }

        });
              }
              return null;
            });
        },
        onApprove: function(data, actions) {
          if (data.orderID) {

            $('#paypal-button-container').hide();
            $('#loading').show();
            fundingSource: paypal.FUNDING.PAYPAL;
            var form = document.querySelector('#payment-form');
            document.querySelector('#order_id').value = data.orderID;
            form.submit();
			 
          }

        },
        onDisplay: function() {
          $("#loading").hide();
        },
        onError: function(err) {
          $('#paypal-button-container').show();
          $('#loading').hide();
          showError("Something went wrong, please try again later, or use a different payment method");
        }
      }).render('#paypal-button-container');

    } else {

      showError("Something went wrong, please try again later, or use a different payment method");
      $('#loading').hide();
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

 <script>
    $(document).ready(function() {
      // Handle payment option change event
      const stripeOption = document.getElementById('stripeOption');
      const paypalOption = document.getElementById('paypalOption');
      const stripeForm = document.getElementById('stripe-form');
      const paypalForm = document.getElementById('paypal-form');

      stripeOption.addEventListener('change', function() {
        if (this.checked) {
          stripeForm.style.display = 'block';
          paypalForm.style.display = 'none';
		
        }
      });

      paypalOption.addEventListener('change', function() {
        if (this.checked) {
          stripeForm.style.display = 'none';
          paypalForm.style.display = 'block';
		
        }
      });
    });
  </script>



<script>
  document.getElementById("checkoutButton").addEventListener("click", function() {
  // Disable the button
  // this.disabled = true;

  // Add the loading overlay and spinner
  var loadingOverlay = document.createElement("div");
  loadingOverlay.classList.add("loading-overlay");
  var loadingSpinner = document.createElement("div");
  loadingSpinner.classList.add("loading-spinner");
  loadingOverlay.appendChild(loadingSpinner);
  document.body.appendChild(loadingOverlay);

  // Simulate a delay (you can replace this with your actual checkout logic)
  setTimeout(function() {
    // Remove the loading overlay and spinner
    loadingOverlay.remove();

    // Enable the button
    document.getElementById("checkoutButton").disabled = false;
  }, 8000);
});

</script>


@endsection