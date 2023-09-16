

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
        <h4 class="page-title mb-0"><?php echo e(__('All Paid Orders')); ?></h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="<?php echo e(route('user.dashboard')); ?>"><i class="fa-solid fa-id-badge mr-2 fs-12"></i><?php echo e(__('Dashboard')); ?></a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(route('user.my_orders')); ?>"><?php echo e(__('Orders List')); ?></a></li>
        </ol>
    </div>

</div>
<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">

	    <div class="col-lg-4 col-md-4 col-xm-4 ">

<a href="<?php echo e(route('user.my_inProcess_orders')); ?>" class="bg-dark">

	<div class="card  text-white" style="background:#3C3465">

	  <h5 class="card-header">

		<?php

          $comps = Illuminate\Support\Facades\DB::table('orders')->whereIn('order_status_id',[2,3])->where('customer_id',auth()->user()->id)->where('payment_status',1)->count();

          echo $comps; 

        ?>

	  </h5>

	  <div class="card-body">

		<h5 class="card-title" style="color:#f49d1d">In Process Orders</h5>

	  </div>

	</div>

</a>

 </div><div class="col-lg-4 col-md-4 col-xm-4">

<a href="<?php echo e(route('user.my_requestedForRevision_orders')); ?>" class="bg-dark">

	<div class="card  text-white" style="background:#3C3465">

	  <h5 class="card-header">

		<?php

          $comps = Illuminate\Support\Facades\DB::table('orders')->where('order_status_id',4)->where('customer_id',auth()->user()->id)->where('payment_status',1)->count();

          echo $comps;

        ?>

	  </h5>

	  <div class="card-body">

		<h5 class="card-title" style="color:#f49d1d">Requested For Revision Orders</h5>

	  </div>

	</div>

</a>

 </div><div class="col-lg-4 col-md-4 col-xm-4">

<a href="<?php echo e(route('user.my_completed_orders')); ?>" class="bg-dark">

	<div class="card  text-white" style="background:#3C3465">

	  <h5 class="card-header">

		<?php

          $comps = Illuminate\Support\Facades\DB::table('orders')->where('order_status_id', 5)->where('customer_id',auth()->user()->id)->where('payment_status',1)->count();

          echo $comps; 

        ?>

	  </h5>

	  <div class="card-body">

		<h5 class="card-title" style="color:#f49d1d">Completed Orders</h5>

	  </div>

	</div>

</a>

 </div>





	</div>
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
                                <th>Order ID</th>
                                <th>Service Type</th>
                                <th>Posted</th>
                                <th>Deadline</th>
                                <th>Status</th>
								<th>Assigned To</th>
                           

                            </tr>
                        </thead>
                        <tbody></tbody>
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
			var url = window.location.pathname;
			var value = url.substring(url.lastIndexOf('/') + 1);
			
			var url = "<?php echo e(route('user.my_orders')); ?>";
			//alert(value)
			if(value == 'my_orders'){
				url = "<?php echo e(route('user.my_orders')); ?>"
			} else if(value == 'my_completed_orders') {
				url = "<?php echo e(route('user.my_completed_orders')); ?>"
			} else if(value == 'my_inProcess_orders') {
				url = "<?php echo e(route('user.my_inProcess_orders')); ?>"
			} else if(value == 'my_inProcess_orders') {
				url = "<?php echo e(route('user.my_inProcess_orders')); ?>"
			}  else if(value == 'my_requestedForRevision_orders') {
				url = "<?php echo e(route('user.my_requestedForRevision_orders')); ?>"
			}
			
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
				ajax: url,
				columns: [
					{
						data: 'order_id',
						name: 'order_id',
						orderable: true,
						searchable: true
					},
				
					{
						data: 'service',
						name: 'service',
						orderable: true,
						searchable: true
					},
					{
						data: 'posted',
						name: 'posted',
						orderable: true,
						searchable: true
					},
					{
						data: 'deadline',
						name: 'deadline',
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
						data: 'assigned',
						name: 'assigned',
						orderable: true,
						searchable: true
					},
					
					
				]
			});

		
	
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/relaxed-nobel.35-229-252-74.plesk.page/httpdocs/resources/views/user/orders/my_orders.blade.php ENDPATH**/ ?>