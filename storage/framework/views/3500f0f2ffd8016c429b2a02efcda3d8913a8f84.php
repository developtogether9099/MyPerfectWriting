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
        <h4 class="page-title mb-0"><?php echo e($writer->name); ?>'s Tasks</h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-id-badge mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('admin.writers')); ?>"> <?php echo e(__('Writers')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"> <?php echo e($writer->name); ?></li>
        </ol>
    </div>

</div>
<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- USERS LIST DATA TABEL -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-xm-12">
        <div class="card border-0">

            <div class="card-body pt-2">
                <!-- BOX CONTENT -->
                <div class="box-content">

                    <!-- DATATABLE -->
                    <table id='listUsersTable' class='table listUsersTable' width='100%'>
                        <thead>
                            <tr>
                                <th width="15%"><?php echo e(__('Title')); ?></th>
                                <th width="7%"><?php echo e(__('Client')); ?></th>
                                <th width="7%"><?php echo e(__('Service Type')); ?></th>
                                <th width="7%"><?php echo e(__('Budget')); ?></th>
                                <th width="7%"><?php echo e(__('Posted')); ?></th>
                                <th width="7%"><?php echo e(__('Deadline')); ?></th>
                                <th width="5%"><?php echo e(__('Status')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(__($task->title)); ?></td>
                                <td>
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('users')->where('id', $task->customer_id)->first();
                                    echo $c->name;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('services')->where('id', $task->service_id)->first();
                                    echo $c->name;
                                    ?>
                                </td>
								<td>
									<?php if($task->currency == 'usd'): ?>
									<i class="fa fa-dollar"></i><?php echo e(__($task->total)); ?>

									<?php else: ?> 
									<i class="fa fa-gbp"></i><?php echo e(__($task->total)); ?>

									<?php endif; ?>
									</td>
                                <td><span class="font-weight-bold"><?php echo e(\Carbon\Carbon::parse($task->created_at)->isoFormat('Do MMM YYYY')); ?></span></td>
                                <td><span class="font-weight-bold"><?php echo e(\Carbon\Carbon::parse($task->dead_line)->isoFormat('Do MMM YYYY')); ?></span></td>
                                <td>
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('order_statuses')->where('id', $task->order_status_id)->first();
                                    echo $c->name;
                                    ?>
                                </td>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <!-- END DATATABLE -->

                </div> <!-- END BOX CONTENT -->
            </div>
        </div>
    </div>
</div>
<!-- END USERS LIST DATA TABEL -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/admin/writers/writer_tasks.blade.php ENDPATH**/ ?>