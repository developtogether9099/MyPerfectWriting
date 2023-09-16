

<?php $__env->startSection('css'); ?>
<!-- Sweet Alert CSS -->
<link href="<?php echo e(URL::asset('plugins/sweetalert/sweetalert2.min.css')); ?>" rel="stylesheet" />
<style>
  .no-arrows::-webkit-inner-spin-button,
  .no-arrows::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  .no-arrows {
    -moz-appearance: textfield;
  }

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

@keyframes  spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}


</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- USER PROFILE PAGE -->
<br>
<h3 style="text-align: center; padding-top: 20px; padding-bottom: 20px;"><strong>Follow the steps to place your
    order!</strong></h3>

<!-- Step Progress Bar -->
<div class="row">
  <div class="col-sm-4">
    <div class="progress">
      <div class="progress-bar" role="progressbar" id="progressbar-1" style="width: 0%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <p>Calculate Price</p>
  </div>
  <div class="col-sm-4">
    <div class="progress">
      <div class="progress-bar" role="progressbar" id="progressbar-2" style="width: 0%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <p>Provide Details</p>
  </div>
  <div class="col-sm-4">
    <div class="progress">
      <div class="progress-bar bg-success" role="progressbar" id="progressbar-3" style="width: 0%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <p>Review Order Details</p>
  </div>
</div>


<div class="row">
  <div class="col-lg-8 col-md-8 col-sm-8">
    <div class="card border-0" style="background-color: #3C3465;">
      <div class="card-body pt-2">
        <!-- BOX CONTENT -->
        <div class="box-content" style="color: #ffffff;">
          <form id="update-order" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row" id="step1">
              <div class="col-md-12">
                <h4 class="mt-3 page-title" style="color: #f49d1d;">Calculate Price</h4>
              </div>
              <!-- Step 1 Form Fields -->
              <div class="col-md-12 mt-2">
                <div class="form-group">

                  <select name="service_id" class="form-control" id="f-service" required>
                    <option value="<?php echo e($sservice->id); ?>" selected><?php echo e($sservice->name); ?></option>
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
					<div id="f-service-err" class="text-danger" style="display:none">This field is required</div>
                </div>
              </div>
              <div class="col-md-12 mt-2">
                <div class="form-group">

                  <select name="work_level_id" class="form-control" id="f-wl" required>
                    <option value="<?php echo e($swork_level->id); ?>" selected><?php echo e($swork_level->name); ?></option>
                    <?php $__currentLoopData = $work_levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($wl->id); ?>"><?php echo e($wl->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
				<div id="f-wl-err" class="text-danger" style="display:none">This field is required</div>
                </div>
              </div>
              <input type="hidden" id="pp" value="<?php echo e(format_amount(6.99)['amount']); ?>">
				<input type="hidden" id="today" name="today">
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="quantity">Number of pages</label>
                  <div class="d-flex">
                    <a id="dec" class="bg-primary p-2 rounded mr-3 text-white" style="cursor:pointer">-</a>
                    <input type="number" name="qty" class="text-center no-arrows" id="quantity" value="<?php echo e($order->quantity); ?>" min="1" style="width:100%; border:none">
                    <a id="inc" class="bg-primary p-2 rounded ml-3 text-white" style="cursor:pointer">+</a>
                  </div>
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="deadline-date">Deadline Date</label>
                  <input type="date" name="deadline_date" id="deadline-date" value="<?php echo e($order->dead_line); ?>" class="form-control" required>
                </div>
              </div>
              <div class="col-md-2 mt-2">
                <div class="form-group">
                  <label for="deadline-time">Time</label>
                  <select name="deadline_time" id="deadline-time" class="form-control" required>
					       <option value="<?php echo e($order->deadline_time); ?>"><?php echo e($order->deadline_time); ?></option>
                    <?php for($hour = 0; $hour < 24; $hour++): ?> <?php for($minute=0; $minute < 60; $minute +=15): ?>
					  
					  <option value="<?php echo e(sprintf('%02d:%02d', $hour, $minute)); ?>"><?php echo e(sprintf('%02d:%02d', $hour, $minute)); ?>

                      </option>
                      <?php endfor; ?>
                      <?php endfor; ?>
                  </select>
                </div>
              </div>

              <div id="delivery-time" class="col-md-12 mt-2" style="display: none;">
                <p><i class="fas fa-info-circle"></i> Your order will be delivered within <span id="delivery-days"></span> days and <span id="delivery-hours"></span> hours.</p>
              </div>


            </div>
            <div class="row" style="display: none;" id="step2">
              <div class="col-md-12 mt-3">
                <h4 class="page-title" style="color: #f49d1d;">Paper Details</h4>
              </div>
              <!-- Step 2 Form Fields -->
              <div class="col-md-12 mt-2">
                <div class="form-group">
                  <label for="f-title">Title</label>
                  <input type="text" name="title" id="f-title"  value="<?php echo e($order->title); ?>" class="form-control" placeholder="Title of your document" required>
                </div>
              </div>
              <div class="col-md-12 mt-2">
                <div class="form-group">

                  <label for="f-course">Subject</label>
                  <select name="course" id="f-course" class="form-control" required>
                   <option value="<?php echo e($order->course); ?>"><?php echo e($order->course); ?></option>
                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($subject->name); ?>"><?php echo e($subject->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  </select>
                </div>
              </div>

              <div id="subject-field" class="col-md-12 mt-2" style="display: none;">
                <div class="form-group">
                  <label for="f-subject">Enter Subject Name</label>
                  <input type="text" name="subject" id="f-subject" class="form-control">
                </div>
              </div>


              <div class="col-md-12 mt-2">
                <div class="form-group">
                  <label for="f-formatting">Citation Style</label>
                  <select name="formatting2" id="f-formatting" class="form-control" required>
                    <option value="<?php echo e($order->formatting); ?>"><?php echo e($order->formatting); ?></option>>
                    <?php $__currentLoopData = $citations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $citation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($citation->name); ?>"><?php echo e($citation->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12 mt-2" id="otherStyleField" style="display: none;">
                <div class="form-group">
                  <label for="f-other-style">Enter Citation Name</label>
                  <input type="text" name="formatting" id="f-other-style" class="form-control" placeholder="Enter Citation Name">
                </div>
              </div>


              <div class="col-md-12 mt-2">
                <div class="form-group">
                  <label for="file">Number of Sources</label>
                  <input type="text" name="sources" id="f-sources"  value="<?php echo e($order->sources); ?>" class="form-control" placeholder="Number of Sources">
                </div>
              </div>
              <div class="col-md-12 mt-2">
                <div class="form-group">
                  <label for="f-specifications">Description</label>
                  <textarea name="specifications" id="f-specifications" class="form-control" rows="3" style="height: 150px;" placeholder="Describe your task in detail or attach file with teacher’s instruction" required><?php echo e($order->instruction); ?></textarea>
                </div>
              </div>


              <div class="col-md-12 mt-2">
                <div class="form-group">
                  <label for="file">Attachments</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="file[]" class="custom-file-input" id="file" multiple>
                    </div>
                  </div>
                </div>

              </div>

             <div class="col-md-12 mt-2 row" style="padding-top: 50px;">

                <label for="f-plan">Choose the Expert Level</label>
                <?php $i = 1; $o = 1; ?>
                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6">
                  <div class="card border-0 form-group py-2 plan<?php echo e($i++); ?>" style=" color: #000000; height:200px">
                    <input type="hidden" class="planType" name="planType" value="normal">
                    <h6 class="text-center" style="padding: 10px;"><?php echo e($package->name); ?></h6>
                    <p class="text-center" style="padding: 5px;"><?php echo e($package->description); ?></p>

                    <?php if($package->cost == 0): ?>
                    <p class="text-center">No extra cost</p>
                    <?php else: ?>
                    <p class="text-center"><i class="fa <?php echo e(format_amount(1)['icon']); ?>"></i><span id="premium-amount"><?php echo e(format_amount($package->cost)['amount']); ?></span></p>

                    <?php endif; ?>
					  <?php if($order->package_amount ==  format_amount($package->cost)['amount'] ): ?>
					  <a class="btn btn-primary select<?php echo e($o++); ?>" style="background: #1a1630 "> Selected </a>
					  <?php else: ?> 
					   <a class="btn btn-primary select<?php echo e($o++); ?>"> Select </a>
					  <?php endif; ?>
                  </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

              </div>     
					 


            </div>
            <div class="row" style="display: none;" id="step3">
              <div class="col-md-12 mt-3">
                <h4 class="page-title" style="color: #f49d1d;">Review Order Details</h4>
              </div>
              <!-- Step 3 Form Fields -->
              <div class=" text-white">

                <h3 class="page-title">Personal Information</h3>
                <p>Name<span class="float-right">

                    <?php echo e(__(auth()->user()->name)); ?>

                  </span>
                </p>
                <p>
                  Email
                  <span class="float-right">
                    <?php echo e(__(auth()->user()->email)); ?>

                  </span>
                </p>
                <p>
                  Username
                  <span class="float-right">
                    <?php echo e(__(auth()->user()->username)); ?>

                  </span>
                </p>

                <br>
                <h3 class="page-title">Order Details</h3>
                <p>
                  Title
                  <span class="float-right" id="btitle"> </span>
                </p>

                <p>
                  Amount
                  <span class="float-right"><i class="fa <?php echo e(format_amount(1)['icon']); ?>"></i><span id="btotal"></span> </span>
                </p>
                <p>
                  Service Type
                  <span class="float-right" id="bservice"> </span>
                </p>
                <p>
                  Education Level
                  <span class="float-right" id="bwork_level"> </span>
                </p>
                <p>
                  Writer Level
                  <span class="float-right" id="bplan_type"> </span>
                </p>
                <p>
                  Quantity
                  <span class="float-right"> <span id="bqty"></span> Pages</span>
                </p>
                <p>
                  Instruction
                  <span class="float-right" id="binstruction"> </span>
                </p>
                <p>
                  Citation
                  <span class="float-right" id="bformatting"> </span>
                </p>
                <p>
                  Course
                  <span class="float-right" id="bcourse"> </span>
                </p>
                <p>
                  Sources
                  <span class="float-right" id="bsources"> </span>
                </p>
                <p>
                  Posted On
                  <span class="float-right" id="bposted"> </span>
                </p>
                <p>
                  Deadline Date
                  <span class="float-right" id="bdeadline_date"> </span>
                </p>
                <p>
                  Deadline Time
                  <span class="float-right" id="bdeadline_time"> </span>
                </p>
                <p>
                  My File
                  <span class="float-right mr-2" id="file_name"></span>
                </p>




              </div>

            </div>
            <!-- Prev/Next buttons -->
            <div class="row">
              <div class="col-md-12 mt-2">
                <div class="form-group">
                  <a class="btn btn-primary p-2 float-left" id="prev">Previous</a>
                  <a class="btn btn-primary p-2 float-right" id="next">Next</a>
                  <button style="display:none" class="btn btn-primary p-2 float-right" id="updateOrder">Update Order</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-sm-8 col-md-8">
    <div class="card border-0" style="background-color: #3C3465;">

      <div class="card-body pt-2">



        <div class="box-content" style="color: #ffffff !important;">
          <div class="col-md-12 col-sm-12 pr-4">


            <div class="divider mb-4">
              <div class="divider-text text-muted" style="color: #ffffff !important;">
                <small><?php echo e(__('Purchase Summary')); ?></small>
              </div>
            </div>

            <div>
              <p class="fs-12 p-family"><?php echo e(__('Subtotal')); ?> <span class="checkout-cost"> <i class="fa <?php echo e(format_amount(1)['icon']); ?>"></i><span id="sub_total"><?php echo e($order->total); ?></span></span></p>

            </div>
<div id="checkouts" style="display:none">
            <div class="divider mb-5">
              <div class="divider-text text-muted" style="color: #ffffff !important;">
                <small><?php echo e(__('Total')); ?></small>
              </div>
            </div>


            <div class="input-box mb-5">
              <div class="input-group">
                <input type="text" class="form-control border-right-0 promocode-field" name="promo_code" id="promo_code" placeholder="<?php echo e(__('Promocode')); ?>">
                <label class="input-group-btn">
                  <a class="btn btn-primary" id="apply-promo"><?php echo e(__('Apply')); ?></a>
                </label>
              </div>
              <span id="promocode-error" class="d-none fs-12 text-danger"></span>
            </div>

            <div id="voucher-result" class="d-none">
              <p class="fs-12 p-family"><?php echo e(__('Discount Applied')); ?> <span class="checkout-cost"> <i class="fa <?php echo e(format_amount(1)['icon']); ?>"></i> <span id="total_discount"></span></span></p>
            </div>

            <div>
              <p class="fs-12 p-family"><?php echo e(__('Total Payment')); ?> <span class="checkout-cost"> <i class="fa <?php echo e(format_amount(1)['icon']); ?>"></i> <span class="text-info" id="gtotal"><?php echo e($order->total); ?></span></span></p>
            </div>




            <button type="button" class="btn btn-primary" id="checkout" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#exampleModal2">Checkout</button>
            <br>
            <div class="divider mb-4">
              <div class="divider-text text-muted" style="color: #ffffff !important;">
                <small><?php echo e(__('Secure Checkout')); ?></small>
              </div>
            </div>
            <div>
              <img src="<?php echo e(URL::asset('img/payments/secure.png')); ?>" style="background-color: #ffffff; border-radius: 0.5rem;">
            </div>

</div>

            <div id="code" style="display: none;">
              <div class="pb-0">
                <div class="divider mb-5">
                  <div class="divider-text text-muted">
                    <small><?php echo e(__('Select Payment Option')); ?></small>
                  </div>
                </div>
                <div class="form-group" id="toggler">
                  <div class="text-center">
                    <div class="btn-group btn-group-toggle w-100" data-toggle='buttons'>
                      <div class="row w-100">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                          <label class="gateway btn rounded p-0" data-bs-toggle="collapse">
                            <a onclick="showform()" data-bs-toggle="modal" data-bs-target="#exampleModal2" class="gateway btn rounded p-0" href="#">
                              <img src="<?php echo e(URL::asset('img/payments/stripe.svg')); ?>">
                            </a>
                          </label>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                          <label class="gateway btn rounded p-0" data-bs-toggle="collapse">
                            <a onclick="showform2()" data-bs-toggle="modal" data-bs-target="#exampleModal" id="paypall" class="gateway btn rounded p-0" href="#">
                              <img src="<?php echo e(URL::asset('img/payments/paypal.svg')); ?>">
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
                    <img src="<?php echo e(URL::asset('img/payments/paypal.svg')); ?>" alt="PayPal Logo" style="float: right; width: 38%;">
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
                    <img src="<?php echo e(URL::asset('img/payments/credit.png')); ?>" alt="Stripe" style="float: right; width: 38%;">
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
                    <p class="fs-12 p-family">Order ID: <span class="checkout-cost"><span id="o_id"><?php echo e($order->id); ?></span></span></p>
                    <p class="fs-12 p-family">Pages: <span class="checkout-cost"><span id="pages"><?php echo e($order->quantity); ?></span></span></p>
                    <p class="fs-12 p-family">Deadline: <span class="checkout-cost"><span id="dl"><?php echo e($order->dead_line); ?></span></span></p>
                    <p class="fs-12 p-family">Education Level: <span class="checkout-cost"><span id="el"><?php echo e($swork_level->name); ?></span></span></p>
                    <p class="fs-12 p-family">Subtotal: <span class="checkout-cost"><i class="fa <?php echo e(format_amount(1)['icon']); ?>"></i><span id="sub_total2"><?php echo e($order->total); ?></span></span></p>
                    <p id="discount" style="display:none" class="fs-12 p-family">Discount Applied: <span class="checkout-cost"><i class="fa <?php echo e(format_amount(1)['icon']); ?>"></i><span id="discount_amount">0</span></span></p>
                    <p class="fs-12 p-family" style="color: #ffffff;">Total Payment: <span class="checkout-cost"><i class="fa <?php echo e(format_amount(1)['icon']); ?>"></i><span class="text-info" id="gtotal2"><?php echo e($order->total); ?></span></span></p>
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


 <form id="payment-form" method="POST" action="<?php echo e(route('paypal_checkout_process')); ?>">
    <?php echo csrf_field(); ?>
    <input id="order_id" name="order_id" type="hidden" />
  </form>

  <div id="publishable_key" data-publishablekey="<?php echo e(env('STRIPE_KEY')); ?>"></div>
  <div id="process_url" data-processurl="<?php echo e(route('stripe_process')); ?>"></div>



  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('js'); ?>
  <!-- Add your JavaScript code here -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var courseSelect = document.getElementById('f-course');
      var subjectField = document.getElementById('subject-field');

      courseSelect.addEventListener('change', function() {
        if (courseSelect.value === 'Other') {
          subjectField.style.display = 'block';
        } else {
          subjectField.style.display = 'none';
        }
      });
    });
  </script>

  <script>
    var currentDate = new Date().toISOString().split('T')[0];
    document.getElementById("deadline-date").setAttribute("min", currentDate);

    document.getElementById("deadline-date").addEventListener("change", updateDeliveryTime);
    document.getElementById("deadline-time").addEventListener("change", updateDeliveryTime);

    function updateDeliveryTime() {
      var dateValue = document.getElementById("deadline-date").value;
      var timeValue = document.getElementById("deadline-time").value;

      if (dateValue && timeValue) {
        var deadline = new Date(dateValue + " " + timeValue);
        var current = new Date();

        var diffInTime = deadline.getTime() - current.getTime();
        var diffInDays = Math.floor(diffInTime / (1000 * 3600 * 24));
        var diffInHours = Math.floor((diffInTime % (1000 * 3600 * 24)) / (1000 * 3600));

        document.getElementById("delivery-days").textContent = diffInDays;
        document.getElementById("delivery-hours").textContent = diffInHours;

        document.getElementById("delivery-time").style.display = "block";
      }
    }
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function(event) {


      var currentStep = 1; // Current step tracker

      // Next button click event
      document.getElementById("next").addEventListener("click", function(event) {
        event.preventDefault();

        // Validation logic for each step can be added here

        // Proceed to next step
        if (currentStep === 1) {
          // Hide Step 1 and show Step 2
			
			var s= document.getElementById("f-service").value;
            var w= document.getElementById("f-wl").value;
		    var d= document.getElementById("deadline-date").value;
            var t= document.getElementById("deadline-time").value;
			if(s === ''){
				$("#f-service-err").show();
			} else {
				$("#f-service-err").hide();
			}
			if(w === ''){
				$("#f-wl-err").show();
			} else {
				$("#f-wl-err").hide();
			} 
			if(s !== '' && w !== '' && d !== ''){
			  document.getElementById("step1").style.display = "none";
			  document.getElementById("step2").style.display = "block";
			  document.getElementById("progressbar-1").style.width = "100%";
			  document.getElementById("next").style.display = "none";
			  document.getElementById("updateOrder").style.display = "block";
          		// Update progress bar width
          		//document.querySelector(".progress-bar").style.width = "66%";
          	  currentStep = 2;
			}
        } else if (currentStep === 2) {
          // Hide Step 2 and show Step 3
          document.getElementById("step2").style.display = "none";
          // Update progress bar width
          document.querySelector(".progress-bar").style.width = "100%";
          currentStep = 3;
        }
      });

      // Previous button click event
      document.getElementById("prev").addEventListener("click", function(event) {
        event.preventDefault();

        // Go back to previous step
        if (currentStep === 2) {
          // Hide Step 2 and show Step 1
          document.getElementById("step2").style.display = "none";
          document.getElementById("step1").style.display = "block";
          document.getElementById("next").style.display = "block";
          document.getElementById("updateOrder").style.display = "none";
          // Update progress bar width
          document.querySelector(".progress-bar").style.width = "33%";
          currentStep = 1;
        } else if (currentStep === 3) {
          // Hide Step 3 and show Step 2
          document.getElementById("step3").style.display = "none";
          document.getElementById("step2").style.display = "block";
          // Update progress bar width
          document.querySelector(".progress-bar").style.width = "66%";
          currentStep = 2;
        }
      });
    });
  </script>
  <script>
    document.getElementById('f-formatting').addEventListener('change', function() {
      var otherStyleField = document.getElementById('otherStyleField');
      if (this.value === 'Other') {
        otherStyleField.style.display = 'block';
      } else {
        otherStyleField.style.display = 'none';
      }
    });
  </script>
  <script>
    $(document).ready(function() {
		var currentDate = new Date();
		var year = currentDate.getFullYear();
		var month = currentDate.getMonth() + 1;
		var day = currentDate.getDate();
		var formattedDate = year + "-" + month + "-" + day;
		$('#today').val(formattedDate);
      var s = null;

      $('#inc').click(function() {
        var quantity = $('#quantity').val();
        quantity++;
        $('#quantity').val(quantity);
        var pp = $('#pp').val();
        var amount = pp * parseInt(quantity);
        amount = parseFloat(amount).toFixed(2)
        $('#qty').text(quantity)
        $('#sub_total').text(amount)
      });
      $('#dec').click(function() {
        var quantity = $('#quantity').val();
        quantity--;
        if (quantity >= 1) {
          $('#quantity').val(quantity);
          var pp = $('#pp').val();
          var amount = pp * parseInt(quantity);
          amount = parseFloat(amount).toFixed(2)
          $('#qty').text(quantity)
          $('#sub_total').text(amount)
        }

      });
      $('#quantity').keyup(function() {
        var quantity = $('#quantity').val();
        var pp = $('#pp').val();
        var amount = pp * parseInt(quantity);
        amount = parseFloat(amount).toFixed(2)
        $('#qty').text(quantity)
        $('#sub_total').text(amount)
      });
      $('#f-service').change(function() {
        var service = this.options[this.selectedIndex].text;
        $('#service').text(service)
        var pp = $('#pp').val();
        var amount = pp;
        var qty = 1;
        $('#qty').text(qty)
        $('#sub_total').text(amount)
        s = service;
      });



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


    });
  </script>

  <script>
    var o = "<?php echo e($order->total); ?>";


    $(document).ready(function() {
      var bool = false;
      $('#updateOrder').click(function() {
		  var title = $('#f-title').val();
		  var subject = $('#f-course').val();
		  var citation = $('#f-formatting').val();
		  var sources = $('#f-sources').val();
		  var desc = $('#f-specifications').val();
		  	function validateFormFields() {
        var isValid = true;

        // Reset previous error messages
        $('input, select').removeClass('is-invalid');
        $('.error-tooltip').remove();

        // Validate each required field
        $('input[required], select[required]').each(function() {
          if (!$(this).val()) {
            $(this).addClass('is-invalid');
            $(this).after('<div class="error-tooltip">This field is required</div>');
            isValid = false;
          }
        });

        return isValid;
      }
		  if(validateFormFields()) { 
        bool = true;
		document.getElementById("progressbar-2").style.width = "100%";
		  }
      });
      $('#update-order').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this); // Get form data
        var url = "<?php echo e(route('user.update_unpaid_order', $order->id)); ?>"; // Replace with the actual URL for submitting the order
        if (bool == true) {
		
          bool = false;
			console.log(formData)
            $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              if (response.status == 200) {
                document.getElementById("step2").style.display = "none";
                document.getElementById("step3").style.display = "block";
                
                $('#btotal').text(response.total)
                $('#btitle').text(response.title)
                $('#bqty').text(response.qty)
                $('#bcourse').text(response.course)
                $('#bsources').text(response.sources)
                $('#binstruction').text(response.instruction)
                $('#bformatting').text(response.formatting)
                $('#bposted').text(response.posted)
                $('#bdeadline_date').text(response.deadline_date)
                $('#bdeadline_time').text(response.deadline_time)
                $('#bservice').text(response.service)
                $('#bwork_level').text(response.work_level)
                $('#bplan_type').text(response.plan_type)
                $('#sub_total').text(response.total)
				   $('#gtotal2').text(response.total)
				     $('#sub_total2').text(response.total)
                $('#gtotal').text(response.total)
				$('#file_name').text(response.file_name)
				$('#file_path').attr("href", response.file_path)
				$('#checkouts').show();
                o = response.total;
              
                $('#next').hide();
				  document.getElementById("progressbar-3").style.width = "100%";
				   $('#updateOrder').hide();
          $('#prev').hide();
                
              }
              console.log(response);
              // You can show a success message or redirect to a success page
            },
           
          });
        }
      });
    });
  </script>

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
    $('#apply-promo').click(function() {
      var promo_code = $('#promo_code').val();
      $.ajax({
        type: 'POST',
        url: "<?php echo e(route('user.apply_promo')); ?>",
        data: {
          "_token": "<?php echo e(csrf_token()); ?>",
          "promo_code": promo_code
        },
        success: function(data) {
          if (data.error != null) {
            $('#promocode-error').removeClass('d-none');
            $('#promocode-error').text(data.error)
          } else {
            $('#voucher-result').removeClass('d-none');
            $('#total_discount').text(data.discount)
            $('#gtotal').text('$' + data.total)
			     $('#gtotal2').text(data.total)
            $('#discount').show()
            $('#discount_amount').text(data.discount)
			     o = data.total;
          }

        }
      });

    });
  </script>
  <script src="https://www.paypal.com/sdk/js?currency=<?php echo e(currency()); ?>&client-id=<?php echo e(env('PAYPAL_CLIENT_ID')); ?>"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script>
  document.addEventListener("DOMContentLoaded", function(event) {

    if (window.hasOwnProperty("paypal")) {
      paypal.Buttons({

        createOrder: function(data, actions) {
          return axios.post("<?php echo e(route('paypal_checkout_generate_token')); ?>")
            .then(function(response) {
              if (response.data.status == 'success') {
				 
                     return actions.order.create({
          purchase_units: [{
            description: 'GnG Order',
            amount: {
              value: o
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

  <?php $__env->stopSection(); ?>
	
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/user/orders/edit.blade.php ENDPATH**/ ?>