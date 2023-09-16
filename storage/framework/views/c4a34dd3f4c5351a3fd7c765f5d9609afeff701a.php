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
        <h4 class="page-title mb-0"><?php echo e(__('All Packages')); ?></h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-id-badge mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
            <li class="breadcrumb-item" aria-current="page"><?php echo e(__('Package List')); ?></li>
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
                                <th width="7%"><?php echo e(__('Name')); ?></th>
                                <th width="7%"><?php echo e(__('Cost')); ?></th>
                                <th width="5%"><?php echo e(__('Status')); ?></th>
                               <th width="5%"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php echo e($d->name); ?>

                                
                                </td>
                                <td>
                                   
                                    <?php echo e($d->cost); ?>

                                </td>
                                
                             
                                <td>
                                    <?php if($d->status == 1): ?>
                                    <a href="<?php echo e(route('admin.package_inactive')); ?>?package=<?php echo e($d->id); ?>">

                                    	<input type="checkbox" name="enable-gcp" class="custom-switch-input" checked>
                                        <span class="custom-switch-indicator"></span>
                                    </a>
                                    <?php else: ?>
                                    <a href="<?php echo e(route('admin.package_active')); ?>?package=<?php echo e($d->id); ?>">

                                        <span class="custom-switch-indicator"></span>
                                    </a>
                                    <?php endif; ?>
                                </td>
                             
								     <td>
                                    
                                    <a href="<?php echo e(route('admin.package_edit', $d->id)); ?>">
										edit
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/admin/currency/packages.blade.php ENDPATH**/ ?>