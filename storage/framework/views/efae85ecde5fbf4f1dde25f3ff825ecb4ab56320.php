

<?php $__env->startSection('page-header'); ?>
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0"><?php echo e(__('Support Request')); ?></h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="<?php echo e(route('user.dashboard')); ?>"><i class="fa-solid fa-messages-question mr-2 fs-12"></i><?php echo e(__('User')); ?></a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('user.support')); ?>"> <?php echo e(__('Support Request')); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('#')); ?>"> <?php echo e(__('Support Request Details')); ?></a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>						
	<!-- SUPPORT REQUEST -->
	<div class="row">
		<div class="col-lg-9 col-md-9 col-xm-12">
			<div class="card overflow-hidden border-0">
				<div class="card-header p-4 pl-5 block">
					<p class="card-title mb-4"><?php echo e(__('Ticket Subject')); ?>: <span class="text-info"><?php echo e($ticket->subject); ?></span></p>
					<p class="card-title"><?php echo e(__('Ticket')); ?> ID: <span class="text-info"><?php echo e($ticket->ticket_id); ?></span></p>
					<span class="cell-box fs-14 support-header support-<?php echo e(strtolower($ticket->status)); ?>"><?php echo e($ticket->status); ?></span>
				</div>
				<div class="card-body pt-5">	
					<div class="row">	
						<div class="background-color p-4" id="support-messages-box">
							<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if($message->role != 'admin'): ?>
									<div class="background-white support-message mb-5 ">
										<p class="font-weight-bold fs-11"><i class="fa-sharp fa-solid fa-calendar-clock mr-2"></i><?php echo e(date_format($message->created_at, 'd M Y H:i A')); ?> <span><?php echo e(__('Your Message')); ?></span></p>
										<p class="fs-14 mb-1"><?php echo e($message->message); ?></p>
										<?php if($message->attachment): ?>
											<p class="font-weight-bold fs-11 mb-1"><?php echo e(__('Attachment')); ?></p>
											<a class="font-weight-bold fs-11 text-primary" href="<?php echo e(URL::asset($message->attachment)); ?>"><?php echo e(__('View Attached Image')); ?></a>
										<?php endif; ?>										
									</div>
								<?php else: ?>
									<div class="background-white support-message support-response mb-5">
										<p class="font-weight-bold fs-11"><i class="fa-sharp fa-solid fa-calendar-clock mr-2"></i><?php echo e(date_format($message->created_at, 'd M Y H:i A')); ?> <span class="text-primary"><?php echo e(__('Admin Response')); ?></span></p>
										<p class="fs-14 mb-1"><?php echo e($message->message); ?></p>
										<?php if($message->attachment): ?>
											<p class="font-weight-bold fs-11 mt-3 mb-1"><?php echo e(__('Attachment')); ?></p>
											<a class="font-weight-bold fs-11 text-primary" href="<?php echo e(URL::asset($message->attachment)); ?>"><?php echo e(__('View Attached Image')); ?></a>
										<?php endif; ?>	
									</div>
								<?php endif; ?>
								
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>						
						</div>
					</div>

					<form id="" action="<?php echo e(route('user.support.response', ['ticket_id' => $ticket->ticket_id])); ?>" method="post" enctype="multipart/form-data">
						<?php echo csrf_field(); ?>
						<div class="row mt-5">
							<div class="col-12">								
								<div class="input-box">
									<h6 class="font-weight-bold"><?php echo e(__('Response')); ?> : <span class="text-required"><i class="fa-solid fa-asterisk"></i></h6>
									<textarea class="form-control" name="message" id="reply" rows="6" placeholder="Enter your reply message here..."></textarea> 
								</div>									
								<div class="input-box">
									<h6 class="font-weight-bold"><?php echo e(__('Attach File')); ?></h6>
									<div class="input-group file-browser">									
										<input type="text" class="form-control border-right-0 browse-file" placeholder="Include attachment file..." style="margin-right: 80px;" readonly>
										<label class="input-group-btn">
											<span class="btn btn-primary special-btn">
												<?php echo e(__('Browse')); ?> <input type="file" name="attachment" style="display: none;">
											</span>
										</label>
									</div>	
									<span class="text-muted fs-10"><?php echo e(__('JPG | JPEG | PNG | Max 5MB')); ?></span>
									<?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('attachment')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div>					
							</div>

							<div class="col-12 text-center">
								<!-- SAVE CHANGES ACTION BUTTON -->
								<div class="border-0 mb-2">
									<a href="<?php echo e(route('user.support')); ?>" class="btn btn-cancel mr-2"><?php echo e(__('Return')); ?></a>
									<button type="submit" class="btn btn-primary"><?php echo e(__('Reply')); ?></button>	
								</div>
							</div>							
						</div>	
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- END SUPPORT REQUEST -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<script src="<?php echo e(URL::asset('js/avatar.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/user/support/show.blade.php ENDPATH**/ ?>