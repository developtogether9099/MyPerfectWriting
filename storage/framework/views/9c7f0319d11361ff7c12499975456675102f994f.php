

<?php $__env->startSection('css'); ?>
	<!-- Datepicker CSS -->
	<link href="<?php echo e(URL::asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker3.standalone.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7"> 
		<div class="page-leftheader">
			<h4 class="page-title mb-0"><?php echo e(__('New Promocode')); ?></h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-sack-dollar mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('admin.finance.dashboard')); ?>"> <?php echo e(__('Finance Management')); ?></a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('admin.finance.promocodes')); ?>"> <?php echo e(__('Promocodes')); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('#')); ?>"> <?php echo e(__('New Promocode')); ?></a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>						
	<div class="row">
		<div class="col-lg-6 col-md-6 col-xm-12">
			<div class="card border-0">
				<div class="card-header">
					<h3 class="card-title"><?php echo e(__('Create New Promocode')); ?></h3>
				</div>
				<div class="card-body pt-5">									
					<form action="<?php echo e(route('admin.finance.promocodes.store')); ?>" method="POST" enctype="multipart/form-data">
						<?php echo csrf_field(); ?>

						<div class="row">

							<div class="col-lg-6 col-md-6 col-sm-12">				
								<div class="input-box">	
									<h6><?php echo e(__('Promocode Name')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control" id="promo-name" name="promo-name" value="<?php echo e(old('promo-name')); ?>" required>
									</div>
									<?php $__errorArgs = ['promo-name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('promo-name')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div> 							
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">						
								<div class="input-box">	
									<h6><?php echo e(__('Status')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<select id="promo-status" name="status" data-placeholder="<?php echo e(__('Select Promocode Status')); ?>:">			
										<option value="valid" selected><?php echo e(__('Valid')); ?></option>
										<option value="invalid"><?php echo e(__('Invalid')); ?></option>
									</select>
									<?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('status')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>	
								</div>						
							</div>
						
						</div>

						<div class="row mt-2">							
							<div class="col-lg-6 col-md-6col-sm-12">							
								<div class="input-box">								
									<h6><?php echo e(__('Promo Type')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<select id="promo-type" name="promo-type" data-placeholder="<?php echo e(__('Select Promocode Type')); ?>:">			
										<option value="percentage" selected><?php echo e(__('Percentage Discount')); ?></option>
										<option value="fixed"><?php echo e(__('Fixed Discount')); ?></option>
									</select> 
									<?php $__errorArgs = ['promo-type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('promo-type')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6col-sm-12">							
								<div class="input-box">								
									<h6><?php echo e(__('Discount Value')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="number" class="form-control" id="discount" name="discount" value="<?php echo e(old('discount')); ?>" required>
									</div> 
									<?php $__errorArgs = ['discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('discount')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6col-sm-12">							
								<div class="input-box">								
									<h6><?php echo e(__('Single Usage')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('Create only 1 promocode or many others by specifying in the Quantities field')); ?>"></i></h6>
									<select id="promo-usage" name="usage" data-placeholder="<?php echo e(__('Select Promocode Usage')); ?>:" data-callback="singleUsageCheck">			
										<option value=0 selected><?php echo e(__('False')); ?></option>
										<option value=1><?php echo e(__('True')); ?></option>
									</select> 
									<?php $__errorArgs = ['usage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('usage')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6col-sm-12">							
								<div class="input-box">								
									<h6><?php echo e(__('Usage Quantity')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo e(old('quantity')); ?>">
									</div> 
									<?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('quantity')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6col-sm-12">							
								<div class="input-box">								
									<h6><?php echo e(__('Multi Usage by the same User')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span> <i class="ml-3 text-dark fs-13 fa-solid fa-circle-info" data-tippy-content="<?php echo e(__('Allow or Deny the same promocode usage by the same user multiple times')); ?>"></i></h6>
									<select id="languages" name="multi_use" data-placeholder="<?php echo e(__('Set Multi Usage by the same User')); ?>:">			
										<option value=1><?php echo e(__('Allow')); ?></option>
										<option value=0 selected><?php echo e(__('Deny')); ?></option>
									</select> 
									<?php $__errorArgs = ['usage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('usage')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6col-sm-12">							
								<div class="input-box">								
									<h6><?php echo e(__('Valid Until')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group" id="datepicker-container">							    
										<input type="text" class="form-control" placeholder="YYYY-MM-DD" id="valid-until" name="valid-until" value="<?php echo e(old('valid-until')); ?>" required>
									</div> 
									<?php $__errorArgs = ['valid-until'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('valid-until')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div> 						
							</div>
						</div>


						<!-- ACTION BUTTON -->
						<div class="border-0 text-right mb-2 mt-4">
							<a href="<?php echo e(route('admin.finance.promocodes')); ?>" class="btn btn-cancel mr-2"><?php echo e(__('Cancel')); ?></a>
							<button type="submit" class="btn btn-primary"><?php echo e(__('Create')); ?></button>							
						</div>				

					</form>					
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<!-- Bootstrap Datepicker JS -->
	<script src="<?php echo e(URL::asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')); ?>"></script>	
	<script>
		$(function(){

			'use strict';

			$('#datepicker-container input').datepicker({
				autoclose: true,
				todayHighlight: true,
				toggleActive: true,
				format: 'yyyy-mm-dd',
				orientation: "bottom"
			});			
		});

		function singleUsageCheck(value) {

			"use strict";
			console.log(value)

			if (value == 0) {
				document.getElementById('quantity').disabled = false;
			} else {
				document.getElementById('quantity').disabled = true;
			}
		}
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/admin/finance/promocodes/create.blade.php ENDPATH**/ ?>