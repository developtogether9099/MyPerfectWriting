<?php $__env->startSection('css'); ?>
<!-- Telephone Input CSS -->
<link href="<?php echo e(URL::asset('plugins/telephoneinput/telephoneinput.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
<!-- EDIT PAGE HEADER -->
<div class="page-header mt-5-7">
	<div class="page-leftheader">
		<h4 class="page-title mb-0"><?php echo e(__('Create Order')); ?></h4>
		<ol class="breadcrumb mb-2">
			<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-user-shield mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
			<li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('admin.orders')); ?>"> <?php echo e(__('Orders')); ?></a></li>
		
		</ol>
	</div>
</div>
<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- EDIT USER PROFILE PAGE -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-sm-12">
		<div class="card border-0">
			
			<div class="card-body pb-0 p-3 rounded"  style="background-color: #3C3465; color: #ffffff;">
				<form method="POST" class="row" action="<?php echo e(route('admin.storeOrder')); ?>" enctype="multipart/form-data">
					 
            <?php echo csrf_field(); ?>
          
              <div class="col-md-6 mt-2">
                <div class="form-group">
					<label for="quantity">Services</label>
                  <select name="service_id" class="form-control" id="f-service" required>
                    <option value="" disabled selected>What can we do for you?</option>
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  </select>
                  <div id="f-service-err" class="text-danger" style="display:none">This field is required</div>
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
					<label for="quantity">Education Level</label>
                  <select name="work_level_id" class="form-control" id="f-wl" required>
                    <option value="" disabled selected>You study at?</option>
                    <?php $__currentLoopData = $work_levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($wl->id); ?>"><?php echo e($wl->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                  <div id="f-wl-err" class="text-danger" style="display:none">This field is required</div>
                </div>
              </div>
              
              <div class="col-md-2 mt-2">
                <div class="form-group">
                  <label for="quantity">No. of pages</label>
                  
                    <input type="number" name="qty" class="form-control" id="quantity" value="1" min="1" style="width:100%;">
                  
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="deadline-date">Deadline Date</label>
                  <input type="date" name="deadline_date" id="deadline-date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" min="<?php echo e(date('Y-m-d')); ?>" required>
                </div>
              </div>

              <div class="col-md-2 mt-2">
                <div class="form-group">
                  <label for="deadline-time">Time</label>
                  <select name="deadline_time" id="deadline-time" class="form-control" required>
                    <?php
                    $currentHour = date('H');
                    $currentMinute = (int) date('i');
                    $currentMinute = $currentMinute - ($currentMinute % 15); // Round down to the nearest 15 minutes
                    ?>
                    <?php for($hour = 0; $hour < 24; $hour++): ?> <?php for($minute=0; $minute < 60; $minute +=15): ?> <?php $optionValue=sprintf('%02d:%02d', $hour, $minute); $disabled=($hour < $currentHour || ($hour===$currentHour && $minute < $currentMinute)) ? 'disabled' : '' ; $selected=($hour===$currentHour && $minute===$currentMinute) ? 'selected' : '' ; ?> <option value="<?php echo e($optionValue); ?>" <?php echo e($disabled); ?> <?php echo e($selected); ?>>
                      <?php echo e($optionValue); ?>

                      </option>
                      <?php endfor; ?>
                      <?php endfor; ?>
                  </select>
                </div>
              </div>

              <div id="delivery-time" class="col-md-12 mt-2" style="display: none;">
                <p>
                  <i class="fas fa-info-circle"></i> Your order will be delivered within
                  <span id="delivery-days"></span> days and
                  <span id="delivery-hours"></span> hours.
                </p>
              </div>

   <div class="col-md-6 mt-2">
                <div class="form-group">

                  <label for="f-course">Subjects</label>
                  <select name="course" id="f-course" class="form-control" required>
                    <option value="" disabled selected>Select your course name</option>
                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($subject->name); ?>"><?php echo e($subject->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  </select>
                </div>
              </div>

           
         
              
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="f-title">Title</label>
                  <input type="text" name="title" id="f-title" class="form-control" placeholder="Title of your document" required>
                </div>
              </div>
           

           

              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="f-formatting">Citation Style</label>
                  <select name="formatting2" id="f-formatting" class="form-control" required>
                    <option value="" disabled selected>Select your citation style</option>
                    <?php $__currentLoopData = $citations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $citation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($citation->name); ?>"><?php echo e($citation->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
              </div>
            


              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="file">Number of Sources</label>
                  <input type="text" name="sources" id="f-sources" class="form-control" placeholder="Number of Sources" required>
                </div>
              </div>
				   <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="file">Attachments</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="file[]" class="custom-file-input" id="file" multiple>
                    </div>
                  </div>
                </div>

              </div>
              <div class="col-md-12 mt-2">
                <div class="form-group">
                  <label for="f-specifications">Description</label>
                  <textarea name="specifications" id="f-specifications" class="form-control" rows="3" style="height: 150px;" placeholder="Describe your task in detail or attach file with teacher’s instruction" required></textarea>
                </div>
              </div>


           

              <div class="col-md-12 mt-2 row" style="padding-top: 50px;">

                <label for="f-plan">Choose the Expert Level</label>
                <?php $i = 1;
                $o = 1; ?>
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
                    <a class="btn btn-primary select<?php echo e($o++); ?>"> Select </a>
                  </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

              </div>



            
              
					<button class="btn btn-primary btn-block">Submit</button>


          </form>
			</div>
		</div>
	</div>
</div>
<!-- EDIT USER PROFILE PAGE -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<!-- Telephone Input JS -->
<script src="<?php echo e(URL::asset('plugins/telephoneinput/telephoneinput.js')); ?>"></script>
<script>
	$(".plan1").css("pointer-events", "none");
      $('.select1').css("background", "#1a1630");
      $('.select1').text("Selected");
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
	$(function() {
		"use strict";

		$("#phone-number").intlTelInput();
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/admin/orders/create.blade.php ENDPATH**/ ?>