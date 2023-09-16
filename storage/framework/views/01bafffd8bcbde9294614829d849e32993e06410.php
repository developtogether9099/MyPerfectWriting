

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
                              <span class="font-weight-bold"><?php echo e(\Carbon\Carbon::parse($order->created_at)->isoFormat('Do MMM YYYY')); ?></span>
                                 
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
                                    <a href="<?php echo e($order->file_path); ?>" download><?php echo e($order->file); ?></a>
                                </td>
                            </tr>
                          
                             
                          
                            <tr>
                               <th><?php echo app('translator')->get('Status'); ?></th>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('order_statuses')->where('id', $order->order_status_id)->first();
                                    echo $c->name;
									if($c->id == 3){
                                    ?>
									<br>
									<a class="btn btn-primary" href="<?php echo e(route('admin.approve')); ?>?id=<?php echo e($order->id); ?>">Approve</a>
									<?php } ?>
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
                                    $c = Illuminate\Support\Facades\DB::table('submitted_works')->where('order_id', $order->id)->get();
                                    if ($c->count() > 0) {

                                       foreach ($c as $e) {?>

                                           <a href="<?php echo e($e->name); ?>" download><?php echo e($e->display_name); ?></a><br>

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
        <form action="<?php echo e(route('user.comment')); ?>" method="post" enctype="multipart/form-data">
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
                <button type="submit" class="btn btn-success my-3">Submit</button>
            </div>
        </form>
        <div>
            <h4>Conversations</h4>
            <div class="row">
                <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3">
                    <?php if($comment->user_id == auth()->user()->id): ?>
                    <h4>You:</h4>
                    <?php else: ?>
                    <?php
                    $c = Illuminate\Support\Facades\DB::table('users')->where('id', $comment->user_id)->first();
                    echo $c->name;
                    ?>
                    <?php endif; ?>
                </div>
                <div class="col-lg-9">
                    <p><?php echo e($comment->body); ?> (Posted: <small> <?php echo e($comment->updated_at); ?></small>) <br>
                        <?php if($comment->file_path != null): ?>
                        File: <a class="text-primary" href="<?php echo e($comment->file_path); ?>" download><?php echo e($comment->file); ?></a> </p>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/admin/orders/order_details.blade.php ENDPATH**/ ?>