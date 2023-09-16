

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
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-0">
                <h3> <?php echo e(__($order->number)); ?></h3>
                <div class="table-responsive">
                    <table class="table ">

                        <tbody>


                            <tr>
                                <th><?php echo app('translator')->get('Title'); ?></th>
                                <td>
                                    <?php echo e(__($order->title)); ?> <br>


                                </td>
                            </tr>

                            <tr>
                                <th><?php echo app('translator')->get('Budget'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Referral Bonus'); ?>">
									<?php if($order->currency = 'usd'): ?>
									<i class="fa fa-dollar"></i><?php echo e($order->total); ?>

									<?php else: ?> 
									<i class="fa fa-gbp"></i><?php echo e($order->total); ?>

									<?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo app('translator')->get('Service Type'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Referral Bonus'); ?>">
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('services')->where('id', $order->service_id)->first();
                                    echo $c->name;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Quantity</th>
                                <td><?php echo e($order->quantity); ?> Pages</td>
                            </tr>
                    
                            <tr>
                                <th><?php echo app('translator')->get('Posted'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Status'); ?>">
                              <span class="font-weight-bold"><?php echo e(date('Y-m-d h:i:A',strtotime($order->created_at))); ?></span>
                                 
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo app('translator')->get('Deadline'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                            <span class="font-weight-bold"><?php echo e(date('Y-m-d h:i:A',strtotime($order->dead_line))); ?></span>
                                 
                                 </td>
                            </tr>
							 <tr>
                                <th><?php echo app('translator')->get('Client Files'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
									<?php $files = Illuminate\Support\Facades\DB::table('attachments')->where('order_id', $order->id)
									->where('uploader_id', $order->customer_id)->get(); ?>
									<?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e($file->file_path); ?>" download class="text-primary"><i class="fa fa-download"></i> <?php echo e($file->file); ?></a> <br>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                            </tr>
                          
                             
                          
                            <tr>
                               <th><?php echo app('translator')->get('Status'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('order_statuses')->where('id', $order->order_status_id)->first();
                                    echo $c->name;
									
                                    ?>
								
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo app('translator')->get('Revision Requested'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('submitted_works')
                                        ->where('order_id', $order->id)
                                        ->where('needs_revision', '<>', null)
                                        ->first();
                                    if ($c)
                                        echo $c->needs_revision;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo app('translator')->get('Attachments'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('attachments')->where('uploader_id', 1)->where('order_id', $order->id)->get();
                                    if ($c->count() > 0) {

                                       foreach ($c as $e) {?>

                                           <a href="<?php echo e($e->file_path); ?>" download><?php echo e($e->file); ?></a><br>

                                            <?php  }

                                    }
                                    ?>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
	<div class="col-lg-6">
	<?php if( $order->order_status_id != 5): ?>
    
        <form action="<?php echo e(route('admin.submit_work')); ?>" method="post" enctype="multipart/form-data">
			<h4>Submit Task to Client</h4>
            <?php echo csrf_field(); ?>
             <input type="hidden" name="id" value="<?php echo e($order->id); ?>">
            <div class="form-group">
                <label for="">Message</label>
                <textarea name="message" class="form-control" placeholder="Your Message"></textarea>
            </div>
            <div class="form-group">
                <label for="">File</label>
                <input type="file" name="name[]" class="form-control" multiple>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success my-3">Submit</button>
            </div>
        </form>
<?php endif; ?>

		<?php if( $order->payment_status == 1): ?>

	
	 <div class="card border-0" style="background-color: #3C3465;">
      <div class="card-body pt-2">
        <div class="box-content" style="color: #ffffff;">
          <div class=" text-white ">
	


				
					<div class="row" >	
						<div class="p-4" id="support-messages-box" style="height:60vh; overflow:scroll; overflow-x:hidden">
<?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $w = Illuminate\Support\Facades\DB::table('users')->where('username', $conv->sender)->first(); ?>
							<?php if($conv->sender != 'admin'): ?>
						<div class="background-white support-message mb-5">
					<p class="font-weight-bold text-primary fs-11"><i class="fa-sharp fa-solid fa-calendar-clock mr-2"></i><?php echo e(date('Y-m-d h:i:A', strtotime($conv->created_at))); ?> MPW</p>
						<p class="fs-14 text-dark mb-1"><?php echo e($conv->message); ?></p><?php if($conv->attachment != null): ?>

											<p class="font-weight-bold fs-11 text-primary mb-1"><?php echo e(__('Attachment')); ?></p>

											<a class="font-weight-bold fs-11 text-primary" download href="<?php echo e($conv->attachment_path); ?>"><?php echo e($conv->attachment); ?></a>

										<?php endif; ?>

					
																		
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
					<form action="<?php echo e(route('admin.admin_send_message')); ?>" method="post" enctype="multipart/form-data">	
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
	<?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/admin/orders/order_details.blade.php ENDPATH**/ ?>