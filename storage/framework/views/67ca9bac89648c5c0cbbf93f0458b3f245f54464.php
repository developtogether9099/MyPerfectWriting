<?php $__env->startSection('css'); ?>
<!-- Telephone Input CSS -->
<link href="<?php echo e(URL::asset('plugins/telephoneinput/telephoneinput.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
<!-- EDIT PAGE HEADER -->
<div class="page-header mt-5-7">
	<div class="page-leftheader">
		<h4 class="page-title mb-0"><?php echo e(__('Create Writer')); ?></h4>
		<ol class="breadcrumb mb-2">
			<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-user-shield mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
			<li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('admin.writers')); ?>"> <?php echo e(__('Writers')); ?></a></li>
		
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
				<h3 class="card-title"><?php echo e(__('Create Writer')); ?></h3>
			</div>
			<div class="card-body pb-0">
				<form method="POST" action="<?php echo e(route('admin.writer_store')); ?>" enctype="multipart/form-data">
					<?php echo csrf_field(); ?>

					<div class="row">
						<?php
						$faker = Faker\Factory::create();
						$writer = Illuminate\Support\Facades\DB::table('writers')->where('username', $faker->firstname)->first();
						if(empty($writer)){
							$username = $faker->firstname;
						} else {
							$faker = Faker\Factory::create();
							$username = $faker->firstname;
						}
						?>
						<div class="col-sm-6 col-md-6">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12"><?php echo e(__('Username')); ?> <span class="text-muted">(<?php echo e(__('Required')); ?>)</span></label>
									<div class="d-flex align-items-center">
									<input type="text" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="username" id="username" value="<?php echo e($username); ?>" required>
									<a id="get-username"><i class="fas fa-undo"></i></a>
									</div>
									<?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<p class="text-danger"><?php echo e($errors->first('username')); ?></p>
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
									<label class="form-label fs-12"><?php echo e(__('Full Name ')); ?> <span class="text-muted">(<?php echo e(__('Required')); ?>)</span></label>
									<input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" required>
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
						<div class="col-sm-6 col-md-6">
							<div class="input-box">
								<div class="form-group">
									<label class="form-label fs-12"><?php echo e(__('Email ')); ?> <span class="text-muted">(<?php echo e(__('Required')); ?>)</span></label>
									<input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" required>
									<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<p class="text-danger"><?php echo e($errors->first('email')); ?></p>
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
									<label class="form-label fs-12"><?php echo e(__('Password')); ?> <span class="text-muted">(<?php echo e(__('Required')); ?>)</span></label>
									<input type="text" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required>
									<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<p class="text-danger"><?php echo e($errors->first('password')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label class="form-label fs-12"><?php echo e(__('Image')); ?> <span class="text-muted">(<?php echo e(__('Required')); ?>)</span></label>
								<input type="file" class="form-control <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="file" required>
									<?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<p class="text-danger"><?php echo e($errors->first('file')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
							</div>
						</div>
						
					</div>

				
					<div class="card-footer border-0 text-right mb-2 pr-0">
						<a href="<?php echo e(route('admin.writers')); ?>" class="btn btn-cancel mr-2"><?php echo e(__('Return')); ?></a>
						<button type="submit" class="btn btn-primary"><?php echo e(__('Create')); ?></button>
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

<script>
$(document).ready(function() {
    // Handle click event
    $('#get-username').click(function() {
        // Make changes when clicked
        var i = '';

        $.ajax({
            url: '/get-writer-username',
            method: 'GET',
            success: function(response) {
                i = response; 
				$('#username').val(response)
                
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/admin/writers/create.blade.php ENDPATH**/ ?>