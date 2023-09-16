

<?php $__env->startSection('css'); ?>
<!-- Data Table CSS -->
<link href="<?php echo e(URL::asset('plugins/datatable/datatables.min.css')); ?>" rel="stylesheet" />
<!-- Sweet Alert CSS -->
<link href="<?php echo e(URL::asset('plugins/sweetalert/sweetalert2.min.css')); ?>" rel="stylesheet" />
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
                            <?php if($order->order_status_id != 1): ?>
                            <tr>
                                <th><?php echo app('translator')->get('Assigned To'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Benefit / Loss'); ?>">
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('writers')->where('id', $order->staff_id)->first();
                                    echo $c->name;
                                    ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <th><?php echo app('translator')->get('Posted'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                  <span class="font-weight-bold"><?php echo e(date('Y-m-d',strtotime($order->created_at))); ?></span>
                                 
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo app('translator')->get('Deadline'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                  <span class="font-weight-bold"><?php echo e(date('Y-m-d',strtotime($order->dead_line))); ?></span>
                                 
                                </td>
                            </tr>
							 <tr>
                                <th><?php echo app('translator')->get('Client Files'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <a href="<?php echo e($order->file_path); ?>" download><?php echo e($order->file); ?></a>
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
                                <th><?php echo app('translator')->get('Attachments'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('submitted_works')->where('order_id', $order->id)->get();
                                    if ($c->count() > 0) {

                                        foreach ($c as $e) {
                                            # code...
                                            echo $e->display_name . '<br>';
                                        }
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
		  <div class="card">
            <div class="card-body p-2">
        <form action="<?php echo e(route('admin.assign_submit')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="o_id" value="<?php echo e($order->id); ?>">
            <div class="form-group">
                <label for="">Select A Writer</label>
                <select name="writer_id" class="form-control">>
                    <option value="0">Select Writer</option>
                    <?php $__currentLoopData = $writers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $writer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($writer->id); ?>"><?php echo e($writer->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
			
			 <div class="form-group mt-3">
                <label for="">Deadline for Writer</label>
                <input type="datetime-local" class="form-control" name="writer_deadline" required>
            </div>
         
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary p-2 my-3">Assign</button>
            </div>
        </form>
            </div>
</div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/admin/orders/assign_order_details.blade.php ENDPATH**/ ?>