

<?php $__env->startSection('css'); ?>
	<!-- Data Table CSS -->
	<link href="<?php echo e(URL::asset('plugins/datatable/datatables.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0"><?php echo e(__('Promocodes')); ?></h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fa-solid fa-sack-dollar mr-2 fs-12"></i><?php echo e(__('Admin')); ?></a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('admin.finance.dashboard')); ?>"> <?php echo e(__('Finance Management')); ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#"> <?php echo e(__('Promocodes')); ?></a></li>
			</ol>
		</div>
		<div class="page-rightheader">
			<a href="<?php echo e(route('admin.finance.promocodes.create')); ?>" class="btn btn-primary mt-1"><?php echo e(__('Create New Promocode')); ?></a>
		</div>
	</div>	
	<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>	
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xm-12">
			<div class="card border-0">
				<div class="card-header">
					<h3 class="card-title"><?php echo e(__('All Promocodes')); ?></h3>
				</div>
				<div class="card-body pt-2">
					<!-- SET DATATABLE -->
					<table id='promocodesAdminTable' class='table' width='100%'>
							<thead>
								<tr>
									<th width="10%"><?php echo e(__('Promo Name')); ?></th>
									<th width="10%"><?php echo e(__('Promocode')); ?></th>
									<th width="10%"><?php echo e(__('Status')); ?></th>
									<th width="10%"><?php echo e(__('Promo Type')); ?></th>
									<th width="7%"><?php echo e(__('Discount')); ?></th>
									<th width="7%"><?php echo e(__('Quantity Left')); ?></th>																																												
									<th width="10%"><?php echo e(__('Valid Until')); ?></th>
									<th width="7%"><?php echo e(__('Action')); ?></th>
								</tr>
							</thead>
					</table> <!-- END SET DATATABLE -->

				</div>
			</div>
		</div>
	</div>

	<!-- MODAL -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><i class="mdi mdi-alert-circle-outline color-red"></i> <?php echo e(__('Confirm Promocode Deletion')); ?></h4>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="deleteModalBody">
					<div>
						<!-- DELETE CONFIRMATION -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END MODAL -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<!-- Data Tables JS -->
	<script src="<?php echo e(URL::asset('plugins/datatable/datatables.min.js')); ?>"></script>
	<script type="text/javascript">
		$(function () {

			"use strict";
			
			// INITILIZE DATATABLE
			var table = $('#promocodesAdminTable').DataTable({
				"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
				responsive: true,
				colReorder: true,
				"order": [[ 7, "asc" ]],
				language: {
					"emptyTable": "<?php echo e(__('No promocodes created yet')); ?>",
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
				ajax: "<?php echo e(route('admin.finance.promocodes')); ?>",
				columns: [{
						data: 'name',
						name: 'name',
						orderable: true,
						searchable: true
					},
					{
						data: 'custom-code',
						name: 'custom-code',
						orderable: false,
						searchable: true
					},
					{
						data: 'custom-status',
						name: 'custom-status',
						orderable: true,
						searchable: true
					},
					{
						data: 'type',
						name: 'type',
						orderable: true,
						searchable: true
					},
					{
						data: 'discount',
						name: 'discount',
						orderable: true,
						searchable: true
					},
					{
						data: 'usages_left',
						name: 'usages_left',
						orderable: true,
						searchable: true
					},
					{
						data: 'expired_at',
						name: 'expired_at',
						orderable: true,
						searchable: true
					},												
					{
						data: 'actions',
						name: 'actions',
						orderable: false,
						searchable: false
					},
				]
			});

			
			// DELETE CONFIRMATION MODAL
			$(document).on('click', '#deleteSubscriptionButton', function(event) {
				event.preventDefault();
				let href = $(this).attr('data-attr');
				$.ajax({
					url: href
					, beforeSend: function() {
						$('#loader').show();
					},
					// return the result
					success: function(result) {
						$('#deleteModal').modal("show");
						$('#deleteModalBody').html(result).show();
					}
					, error: function(jqXHR, testStatus, error) {
						console.log(error);
						alert("Page " + href + " cannot open. Error:" + error);
						$('#loader').hide();
					}
					, timeout: 8000
				})
			});

		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/admin/finance/promocodes/index.blade.php ENDPATH**/ ?>