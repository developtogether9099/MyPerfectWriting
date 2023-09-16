

<?php $__env->startSection('css'); ?>
<!-- Data Table CSS -->
<link href="<?php echo e(URL::asset('plugins/datatable/datatables.min.css')); ?>" rel="stylesheet" />
<!-- Sweet Alert CSS -->
<link href="<?php echo e(URL::asset('plugins/sweetalert/sweetalert2.min.css')); ?>" rel="stylesheet" />
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
<!-- PAGE HEADER -->
<div class="page-header mt-5-7">
    <div class="page-leftheader">
        <h4 class="page-title mb-0"><?php echo e(__('Order Details')); ?></h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="<?php echo e(route('user.dashboard')); ?>"><i class="fa-solid fa-id-badge mr-2 fs-12"></i><?php echo e(__('Dashboard')); ?></a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('user.my_orders')); ?>"><?php echo e(__('Orders')); ?></a></li>
        </ol>
    </div>

</div>
<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
	
	<div class="col-lg-8 col-md-8 col-sm-8">
    <div class="card border-0" style="background-color: #3C3465;">
      <div class="card-body pt-2">
        <div class="box-content" style="color: #ffffff;">
          <div class=" text-white ">

           <p>
              Order ID
              <span class="float-right" id="btitle"> <?php echo e($order->id); ?> </span>
            </p>
            <p>
              Title
              <span class="float-right" id="btitle"> <?php echo e($order->title); ?> </span>
            </p>

            <p>
              Amount
              <span class="float-right"><i class="fa <?php echo e(format_amount(1)['icon']); ?>"></i><span id="btotal"><?php echo e($order->total); ?></span> </span>
            </p>
            <p>
              Service Type
			<?php $s = Illuminate\Support\Facades\DB::table('services')->where('id', $order->service_id)->first(); ?>
                                    
              <span class="float-right" id="bservice"> <?php echo e($s->name); ?></span>
            </p>
            <p>
              Education Level
			<?php $wl = Illuminate\Support\Facades\DB::table('work_levels')->where('id', $order->work_level_id)->first(); ?>
              <span class="float-right" id="bwork_level"> <?php echo e($wl->name); ?></span>
            </p>
            <p>
              Writer Level
              <span class="float-right" id="bplan_type"><?php echo e($order->package); ?> </span>
            </p>
            <p>
              Quantity
              <span class="float-right"> <span id="bqty"></span><?php echo e($order->quantity); ?> Pages</span>
            </p>
            <p>
              Instruction
              <span class="float-right" id="binstruction"> <?php echo e($order->instruction); ?></span>
            </p>
            <p>
              Citation
              <span class="float-right" id="bformatting"><?php echo e($order->formatting); ?> </span>
            </p>
            <p>
              Course
              <span class="float-right" id="bcourse"> <?php echo e($order->course); ?></span>
            </p>
            <p>
              Sources
              <span class="float-right" id="bsources"> <?php echo e($order->sources); ?></span>
            </p>
            <p>
              Posted On
              <span class="float-right" id="bposted"><?php echo e(date('Y-m-d',strtotime($order->created_at))); ?> </span>
            </p>
            <p>
              Deadline Date
              <span class="float-right" id="bdeadline_date"> <?php echo e($order->dead_line); ?></span>
            </p>
            <p>
              Deadline Time
              <span class="float-right" id="bdeadline_time"><?php echo e($order->deadline_time); ?> </span>
            </p>
            <p>
              My File

              <?php if($order->file != null): ?>
              <a id="file_path" href="<?php echo e($order->file_path); ?>" class="float-right text-white"><i class="fa fa-download"></i> </a>
              <span class="float-right mr-2" id="file_name"><?php echo e($order->file); ?></span>
              <?php else: ?>
              <span class="float-right">no file uploaded</span>
              <?php endif; ?>
            </p>

			  <p>
			Status
			<?php $status= Illuminate\Support\Facades\DB::table('order_statuses')->where('id', $order->order_status_id)->first();  ?>
				  <?php if($status->id == 2 || $status->id == 3): ?>
				  <span class="float-right">In Process</span>
				  <?php else: ?> 
				  <span class="float-right"><?php echo e($status->name); ?></span>
				  <?php endif; ?>

				
              </p> <?php if($order->order_status_id == 5): ?><p> Writer's File

			

			<?php $sw= Illuminate\Support\Facades\DB::table('submitted_works')->where('order_id', $order->id)->get();  ?> <?php $__currentLoopData = $sw; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

				

				  <a class="float-right text-white"  href="<?php echo e($f->name); ?>" download><?php echo e($f->display_name); ?> <i class="fa fa-download"></i></a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				  

			

				

              </p><?php endif; ?>

    

          </div>
        </div>
      </div>
    </div>
  </div>
	
	
    <div class="col-lg-4 col-md-4 col-sm-4">
			<?php if($order->payment_status == 1 && $order->order_status_id == 4): ?>
		    <div class="card border-0" style="background-color: #3C3465;">
      <div class="card-body pt-2">
        <div class="box-content" style="color: #ffffff;">
          <div class=" text-white ">
	<div id="acceptForm">
		       <h4 class="page-title mb-0"><?php echo e(__('Check your Order')); ?></h4>
			  
			  
       				<?php $wf = Illuminate\Support\Facades\DB::table('submitted_works')->where('order_id', $order->id)->get(); ?>
				
		   			<?php if($wf->count() > 0): ?> 

		  			<?php $__currentLoopData = $wf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
					    <div class="form-group">
                			<label for="">Writer's Message</label>
							<textarea name="message" class="form-control" placeholder="Writer Message"><?php echo e($f->message); ?></textarea>
           			 	</div>
			     		<div class="form-group">
							<label for="">Writer's File</label>
							<input type="text" name="file" value="<?php echo e($f->display_name); ?>" class="form-control">
						</div>
						<div class="form-group my-2" id="downloadFile" style="display:none">
								<label for="">Download File</label>
								<a class="float-right text-white"  href="<?php echo e($f->name); ?>" download><i class="fa fa-download"></i></a>
						</div>
			  		
			  
		   			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			  		<div class="form-group" id="selectOption" style="display:none">
						<label for="">Choose</label>
						<select name="file" class="form-control" id="select">
							<option>Select</option>
							<option value="rate order">rate the order</option>
							<option value="mark a revision">mark a revision</option>
						</select>
					</div>
		   		 	<div class="form-group">
						<button type="button" id="accept" class="btn btn-primary my-3">Accept the Order</button>
					</div>
			  		<div class="form-group" id="afterAccept" style="display:none">
						<button type="submit" class="btn btn-primary my-3">Submit</button>
					</div>
					<?php endif; ?>
        	</div>
		<div id="revision" style="display:none">	  
			<h4 class="page-title mb-0"><?php echo e(__('Request For Revision')); ?></h4>  	
			<form action="<?php echo e(route('user.comment')); ?>" method="post" enctype="multipart/form-data" >
				<?php echo csrf_field(); ?>
				<input type="hidden" name="o_id" value="<?php echo e($order->id); ?>">
				<div class="form-group">
					<label for="">Message</label>
					<textarea name="message" class="form-control" placeholder="Your Message"></textarea>
				</div>
				<div class="form-group">
					<label for="">File</label>
					<input type="file" name="file" class="form-control">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary my-3">Submit</button>
				</div>
			</form>
		</div>
		<div id="rateOrder" style="display:none">	  
			<h4 class="page-title mb-0"><?php echo e(__('Rate the Order')); ?></h4>  	
			<form action="<?php echo e(route('user.rate_order', $order->id)); ?>" method="post">
				<?php echo csrf_field(); ?>

				<div class="form-group">
					<label for="">Rate 0/5</label>
					<input type="number" name="rating" min="0" max="5" class="form-control">
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary my-3">Submit</button>
				</div>
			</form>
		</div>

	
    </div>
</div>
    </div>
</div>
  
		<?php endif; ?>
	
	
		<?php if($order->payment_status == 1 && $order->staff_id != 0): ?>
 <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Conversations
</button>
		
    </div>
		<?php endif; ?>
</div>







<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Conversations</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="card border-0" style="background-color: #3C3465;">
      <div class="card-body pt-2">
        <div class="box-content" style="color: #ffffff;">
          <div class=" text-white ">
	


				
					<div class="row" >	
						<div class="p-4" id="support-messages-box" style="height:60vh; overflow:scroll; overflow-x:hidden">
<?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $w = Illuminate\Support\Facades\DB::table('writers')->where('username', $conv->sender)->first(); ?>
							<?php if($w): ?>
						<div class="background-white support-message mb-5">
					<p class="font-weight-bold text-primary fs-11"><i class="fa-sharp fa-solid fa-calendar-clock mr-2"></i><?php echo e(date('Y-m-d h:i:A', strtotime($conv->created_at))); ?> <span><?php echo e($w->username); ?></span></p>
						<p class="fs-14 text-dark mb-1"><?php echo e($conv->message); ?></p>
																		
						</div>
						<?php else: ?>
								<div class="background-white support-message support-response mb-5">
										<p class="font-weight-bold text-primary fs-11"><i class="fa-sharp fa-solid fa-calendar-clock mr-2"></i><?php echo e(date('Y-m-d h:i:A', strtotime($conv->created_at))); ?> <span><?php echo e(__('Your Message')); ?></span></p>
										
										<p class="fs-14 text-dark mb-1"><?php echo e($conv->message); ?></p>
										<?php if($conv->attachment != null): ?>
											<p class="font-weight-bold fs-11 text-primary mb-1"><?php echo e(__('Attachment')); ?></p>
											<a class="font-weight-bold fs-11 text-primary" download href="<?php echo e($conv->attachment_path); ?>"><?php echo e($conv->attachment); ?></a>
										<?php endif; ?>
									</div>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									
							
								
						
									
								
												
						</div>
					<form action="<?php echo e(route('user.send_message')); ?>" method="post" enctype="multipart/form-data">	
						<?php echo csrf_field(); ?>
					<div class="input-box d-flex">
						<input type="hidden" name="o_id" value="<?php echo e($order->id); ?>">
						<input type="hidden" name="receiver_id" value="<?php echo e($order->staff_id); ?>">
					
					 
						
						
        
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

    </div>
  </div>
</div>

<div id="publishable_key" data-publishablekey="<?php echo e(env('STRIPE_KEY')); ?>"></div>
<div id="process_url" data-processurl="<?php echo e(route('stripe_process')); ?>"></div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="https://js.stripe.com/v3/"></script>
<script>
   
 var o = 0;

	$('document').ready(function(){
		$('#accept').click(function(){
			$('#downloadFile').show()
			$('#selectOption').show()
			$('#accept').hide()
		})
		
		$('#select').change(function(){
			var option = $('#select').val();
			if(option == 'mark a revision'){
				$('#acceptForm').hide()
				$('#revision').show()
			} else if(option == 'rate order') {
				$('#acceptForm').hide()
				$('#rateOrder').show()
			} 
			
		})
	});
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


<script src="https://www.paypal.com/sdk/js?client-id=<?php echo e(env('PAYPAL_CLIENT_ID')); ?>"></script>
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
                            value: "<?php echo e($order->total); ?>"
                        },

                    }],
                    application_context: {
                        shipping_preference: 'NO_SHIPPING',

                    }

                });
            },
            onApprove: function(data, actions) {
                // Replace 'YOUR_SERVER_ENDPOINT' with the Laravel route that executes the payment
                return fetch("<?php echo e(route('paypal_process')); ?>", {
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
		url:"<?php echo e(route('user.apply_promo')); ?>",
		data:{
			"_token":"<?php echo e(csrf_token()); ?>",
			"promo_code":promo_code,
			"id":"<?php echo e($order->id); ?>"
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/user/orders/order_details.blade.php ENDPATH**/ ?>