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
        <h4 class="page-title mb-0"><?php echo e(__('All Writers')); ?></h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-id-badge mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
            <li class="breadcrumb-item" aria-current="page"><?php echo e(__('Writers List')); ?></li>
        </ol>
    </div>
    <div class="page-rightheader">
		<a href="<?php echo e(route('admin.writer_create')); ?>" class="btn btn-primary mt-1"><?php echo e(__('Create New Writer')); ?></a>
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
                                <th width="7%"><?php echo e(__('Username')); ?></th>
                                <th width="12%"><?php echo e(__('Email')); ?></th>
                                <th width="7%"><?php echo e(__('Tasks')); ?></th>
                                <th width="5%"><?php echo e(__('Status')); ?></th>
                                <th width="7%"><?php echo e(__('Created at')); ?></th>
                                <th width="7%"><?php echo e(__('Actions')); ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $writers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $writer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($writer->username); ?></td>
                                <td><?php echo e($writer->email); ?></td>
                                <td>
                                    <?php
                                    $no = Illuminate\Support\Facades\DB::table('orders')
                                        ->where('staff_id', $writer->id)
                                        ->count();
                                    ?>
                                    <a class="text-primary" href="<?php echo e(route('admin.writer_tasks')); ?>?writer=<?php echo e($writer->id); ?>"> <i class="fa fa-eye"> <?php echo e($no); ?></i></a>
                                </td>
                                <td>
						
                                    <?php if($writer->status == 1): ?>
                                    <a href="<?php echo e(route('admin.writer_inactive')); ?>?writer=<?php echo e($writer->id); ?>">
										<input type="checkbox" name="enable-gcp" class="custom-switch-input" checked>
                                        <span class="custom-switch-indicator"></span>
                                    </a>
                                    <?php else: ?>
                                    <a href="<?php echo e(route('admin.writer_active')); ?>?writer=<?php echo e($writer->id); ?>">

                                    <span class="custom-switch-indicator"></span>
                                    </a>
                                    <?php endif; ?>
                                </td>
                                <td>
									<span class="font-weight-bold"><?php echo e(\Carbon\Carbon::parse($writer->created_at)->isoFormat('Do MMM YYYY')); ?></span></td>
                    			<td>  
									<a href="<?php echo e(route('admin.writer_edit', $writer->id)); ?>">
										<i class="fa fa-edit"></i>
                                    </a>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/admin/writers/index.blade.php ENDPATH**/ ?>