

<?php $__env->startSection('page-header'); ?>
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0"><?php echo e(__('Checkout')); ?></h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="<?php echo e(route('user.dashboard')); ?>"><i class="fa-solid fa-box-circle-check mr-2 fs-12"></i><?php echo e(__('User')); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(route('user.plans')); ?>"> <?php echo e(__('Pricing Plans')); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('#')); ?>"> <?php echo e(__('Checkout')); ?></a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>	
	<div class="row">
		<div class="col-md-6">
			<div class="card border-0 pt-2">
				<div class="card-body">			
					<div class="text-center">
						<i class="mdi mdi-approval fs-45 text-info mb-4"></i>
						<h4 class="checkout-success"><?php echo e(__('Congratulations')); ?>!</h4>
						<div class="text-center mb-6">
							<p class="mt-5 fs-14"><?php echo e(__('You have successfully Completed Payment process')); ?>.</p>
						</div>						
					
						<div class="text-center pt-2 pb-4">
						
							<a href="<?php echo e(route('user.my_orders')); ?>" id="payment-button" class="btn btn-primary pl-6 pr-6"><?php echo e(__('View Orders')); ?></a>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/user/checkout/success.blade.php ENDPATH**/ ?>