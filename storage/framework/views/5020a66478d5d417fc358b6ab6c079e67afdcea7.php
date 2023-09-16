

<?php $__env->startSection('css'); ?>
<!-- Telephone Input CSS -->
<link href="<?php echo e(URL::asset('plugins/telephoneinput/telephoneinput.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
<!-- EDIT PAGE HEADER -->
<div class="page-header mt-5-7">
	<div class="page-leftheader">
		<h4 class="page-title mb-0"><?php echo e(__('Edit Service')); ?></h4>
		<ol class="breadcrumb mb-2">
			<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-user-shield mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
			<li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('admin.services')); ?>"> <?php echo e(__('Services')); ?></a></li>
		
		</ol>
	</div>
</div>
<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- EDIT USER PROFILE PAGE -->
<div class="row">
	<div class="col-xl-9 col-lg-8 col-sm-12">
		<div class="card border-0">
			<div class="card-header">
				<h3 class="card-title"><?php echo e(__('Edit Service')); ?></h3>
			</div>
			<div class="card-body pb-0">
				<form method="POST" action="<?php echo e(route('admin.service_update')); ?>" enctype="multipart/form-data">
					<?php echo csrf_field(); ?>

					<div class="row">
						<input type="hidden" name="id" value="<?php echo e($service->id); ?>">
						<div class="col-sm-6 col-md-9">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12"><?php echo e(__('Name ')); ?> <span class="text-muted">(<?php echo e(__('Required')); ?>)</span></label>
									<input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e($service->name); ?>" required>
									<?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
									<p class="text-danger"><?php echo e($errors->first('name')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12"><?php echo e(__('Price ')); ?> <span class="text-muted">(<?php echo e(__('Required')); ?>)</span></label>
									<input type="text" class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="price" value="<?php echo e($service->price); ?>" required>
									<?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
									<p class="text-danger"><?php echo e($errors->first('price')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12"><?php echo e(__('Single Spacing Price')); ?> <span class="text-muted">(<?php echo e(__('Required')); ?>)</span></label>
									<input type="text" class="form-control <?php $__errorArgs = ['single_spacing_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="single_spacing_price" value="<?php echo e($service->single_spacing_price); ?>" required>
									<?php $__errorArgs = ['single_spacing_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
									<p class="text-danger"><?php echo e($errors->first('single_spacing_price')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12"><?php echo e(__('Double Spacing Price')); ?> <span class="text-muted">(<?php echo e(__('Required')); ?>)</span></label>
									<input type="text" class="form-control <?php $__errorArgs = ['double_spacing_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="double_spacing_price" value="<?php echo e($service->double_spacing_price); ?>" required>
									<?php $__errorArgs = ['double_spacing_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
									<p class="text-danger"><?php echo e($errors->first('double_spacing_price')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label class="form-label fs-12"><?php echo e(__('Minimum Order Quantity')); ?> <span class="text-muted">(<?php echo e(__('Required')); ?>)</span></label>
								<input type="number" class="form-control <?php $__errorArgs = ['minimum_order_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="minimum_order_quantity" value="<?php echo e($service->minimum_order_quantity); ?>" required>

								<?php $__errorArgs = ['minimum_order_qantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								<p class="text-danger"><?php echo e($errors->first('minimum_order_quantity')); ?></p>
								<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12"><?php echo e(__('Price Type')); ?> <span class="text-muted">(<?php echo e(__('Required')); ?>)</span></label>
									<select id="user-role" name="price_type_id" data-placeholder="<?php echo e(__('Select Price Type')); ?>" required>
										<option value="<?php echo e($price_type_selected->id); ?>" selected> <?php echo e($price_type_selected->name); ?></option>
										<?php $__currentLoopData = $price_type_others; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($pt->id); ?>"><?php echo e($pt->name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<?php $__errorArgs = ['price_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
									<p class="text-danger"><?php echo e($errors->first('price_type')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div>
							</div>
						</div>
					</div>

					<div class="row border-top pt-4 mt-3">
						<div class="col-sm-12 col-md-12">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12"><?php echo e(__('Additional Services')); ?> <span class="text-muted">(<?php echo e(__('Optional')); ?>)</span></label>
									<input type="text" class="form-control <?php $__errorArgs = ['job_role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="job_role" value="<?php echo e(old('job_role')); ?>">
									<?php $__errorArgs = ['job_role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
									<p class="text-danger"><?php echo e($errors->first('job_role')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div>
							</div>
						</div>

					</div>
					<div class="card-footer border-0 text-right mb-2 pr-0">
						<a href="<?php echo e(route('admin.services')); ?>" class="btn btn-cancel mr-2"><?php echo e(__('Return')); ?></a>
						<button type="submit" class="btn btn-primary"><?php echo e(__('Update')); ?></button>
					</div>
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
	$(function() {
		"use strict";

		$("#phone-number").intlTelInput();
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/admin/services/edit.blade.php ENDPATH**/ ?>