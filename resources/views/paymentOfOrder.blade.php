<!DOCTYPE>
<html>
<head>
	<!-- Animate -->
<link href="{{URL::asset('css/animated.css')}}" rel="stylesheet" />

<!-- Bootstrap 5 -->
<link href="{{URL::asset('plugins/bootstrap-5.0.2/css/bootstrap.min.css')}}" rel="stylesheet">

<!-- Icons -->
<link href="{{URL::asset('css/icons.css')}}" rel="stylesheet" />

<!-- P-scrollbar -->
<link href="{{URL::asset('plugins/p-scrollbar/p-scrollbar.css')}}" rel="stylesheet" />

<!-- Simplebar -->
<link href="{{URL::asset('plugins/simplebar/css/simplebar.css')}}" rel="stylesheet">

<!-- Tippy -->
<link href="{{URL::asset('plugins/tippy/scale-extreme.css')}}" rel="stylesheet" />
<link href="{{URL::asset('plugins/tippy/material.css')}}" rel="stylesheet" />

<!-- Toastr -->
<link href="{{URL::asset('plugins/toastr/toastr.min.css')}}" rel="stylesheet" />

<link href="{{URL::asset('plugins/awselect/awselect.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('css/app.css')}}" rel="stylesheet" />

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
</head>

<body>

<!-- PAGE HEADER -->
<div class="page-header mt-5-7 p-3">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">{{ __('Order Details') }}</h4>
      
    </div>

</div>
<!-- END PAGE HEADER -->



<div class="row p-4">
	
	<div class="col-lg-8 col-md-8 col-sm-8">
    <div class="card border-0" style="background-color: #3C3465;">
      <div class="card-body pt-2">
        <div class="box-content" style="color: #ffffff;">
          <div class=" text-white ">

           <p>
              Order ID
              <span class="float-right" id="btitle"> {{$order->id}} </span>
            </p>
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
			<?php $s = Illuminate\Support\Facades\DB::table('services')->where('id', $order->service_id)->first(); ?>
                                    
              <span class="float-right" id="bservice"> {{$s->name}}</span>
            </p>
            <p>
              Education Level
			<?php $wl = Illuminate\Support\Facades\DB::table('work_levels')->where('id', $order->work_level_id)->first(); ?>
              <span class="float-right" id="bwork_level"> {{$wl->name}}</span>
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

          	 @if($attachments->count() > 0)
				@foreach($attachments as $atch)
              <a target="_blank" href="{{$atch->file_path}}" class="float-right text-white"><i class="fa fa-download"></i> </a>
              <span class="float-right mr-2" id="file_name">{{$atch->file}}</span> 
				<br>
				@endforeach
			
              @else
              <span class="float-right">no file uploaded</span>
              @endif
			  </p>
			    <p>
              Payment Status
					 	 @if($order->payment_status == 0)
              <span class="float-right" id="bdeadline_time">Unpaid </span>
					@else 
					<span class="float-right" id="bdeadline_time">Paid </span>
					@endif
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
	@if($order->payment_status == 0)
	<div class="col-lg-4 col-md-4 col-sm-12">
    <div class="card border-0" style="background-color: #3C3465;">
      <div class="card-body pt-2">
        <div class="box-content" style="color: #ffffff;">
          <div class=" text-white ">
	
		<form id='payment-forms' >
            <div class="mb-3">
              <label for="card-element">Cards</label>
              <div id="card-element"></div>
              <div id="card-errors" class="invalid-feedback d-block"></div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block confirm-button pl-6 pr-6 mb-1" disabled>Checkout Now </button>
          </form>
	

	        </div>
        </div>
      </div>
    </div>
  </div>
	@endif
</div>



<?php 

session(['OID'=>$order->id]);
session(['total_amount'=>$order->amount]);
session(['outside'=>true]);
?>





<div id="publishable_key" data-publishablekey="{{ env('STRIPE_KEY') }}"></div>
<div id="process_url" data-processurl="{{ route('stripe_process_payment') }}"></div>



<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="https://js.stripe.com/v3/"></script>
<script>
  document.addEventListener("DOMContentLoaded", function(event) {

    var publishableKey = document.getElementById('publishable_key').dataset.publishablekey;
    var process_url = document.getElementById('process_url').dataset.processurl;

    //document.getElementById('payment-form').style.display = "block";
    //document.getElementById('loading').style.display = "none";

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
    var form = document.getElementById('payment-forms');
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

</body>
</html>