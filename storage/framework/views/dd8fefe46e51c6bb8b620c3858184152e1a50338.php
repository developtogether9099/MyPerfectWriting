

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
        <h4 class="page-title mb-0"><?php echo e(__('All Subjects')); ?></h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-id-badge mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
            <li class="breadcrumb-item" aria-current="page"><?php echo e(__('Subjects List')); ?></li>
        </ol>
    </div>
    <div class="page-rightheader">
        <a href="<?php echo e(route('admin.subject_create')); ?>" class="btn btn-primary mt-1"><?php echo e(__('Create New Subject')); ?></a>
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
                                <th width="5%"><?php echo e(__('Status')); ?></th>
                               <th width="5%"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                         
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

<?php $__env->startSection('js'); ?>
	<!-- Data Tables JS -->
	<script src="<?php echo e(URL::asset('plugins/datatable/datatables.min.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('plugins/sweetalert/sweetalert2.all.min.js')); ?>"></script>
	<script type="text/javascript">
		$(function () {

			"use strict";
			
			var table = $('#listUsersTable').DataTable({
				"lengthMenu": [[10, 50, 100, -1], [25, 50, 100, "All"]],
				responsive: true,
				colReorder: true,
				"order": [[ 0, "desc" ]],
				language: {
					search: "<i class='fa fa-search search-icon'></i>",
					lengthMenu: '_MENU_ ',
					paginate : {
						first    : '<i class="fa fa-angle-double-left"></i>',
						last     : '<i class="fa fa-angle-double-right"></i>',
						previous : '<i class="fa fa-angle-left"></i>',
						next     : '<i class="fa fa-angle-right"></i>'
					}
				},
				pagingType : 'full_numbers',
				processing: true,
				serverSide: true,
				ajax: "<?php echo e(route('admin.subjects')); ?>",
				columns: [
					{
						data: 'name',
						name: 'name',
						orderable: true,
						searchable: true
					},
				
				
				
				
					{
						data: 'status',
						name: 'status',
						orderable: true,
						searchable: true
					},
				
					{
						data: 'actionBtn',
						name: 'actionBtn',
						orderable: true,
						searchable: true
					},
				]
			});

		
	
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/admin/subjects/index.blade.php ENDPATH**/ ?>