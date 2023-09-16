

<?php $__env->startSection('css'); ?>
<!-- Data Table CSS -->
<link href="<?php echo e(URL::asset('plugins/datatable/datatables.min.css')); ?>" rel="stylesheet" />
<!-- Sweet Alert CSS -->
<link href="<?php echo e(URL::asset('plugins/sweetalert/sweetalert2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
<!-- PAGE HEADER -->
<!-- <div class="page-header mt-5-7">
    <div class="page-leftheader">
        <h4 class="page-title mb-0"><?php echo e(__('Dashboard')); ?></h4>
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="<?php echo e(route('user.dashboard')); ?>"><i class="fa-solid fa-chart-tree-map mr-2 fs-12"></i><?php echo e(__('AI Panel')); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('#')); ?>"> <?php echo e(__('Dashboard')); ?></a></li>
        </ol>
    </div>
</div> -->

<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<br>
<!-- USER PROFILE PAGE -->
<style>
/* Styles for mobile devices */
@media (max-width: 767px) {
  #user-dashboard-background {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  #user-dashboard-background .col-lg-6.col-md-6 {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
}
    @keyframes  pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.1);
            opacity: 0.8;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .pulsating-btn {
        animation: pulse 1.5s infinite;
    }

</style>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card border-0">
            <div class="card-body pt-5 pb-5">
            <div class="row mb-6" id="user-dashboard-background">
  <div class="col-lg-6 col-md-6">
    <h4 class="mb-2 mt-2 font-weight-800 fs-24"><?php echo e(__('Welcome')); ?>, <?php echo e(auth()->user()->username); ?></h4>
  </div>
  <div class="col-lg-6 col-md-6 text-right">
    <?php if(auth()->check() && auth()->user()->hasRole('user')): ?>
    <a href="<?php echo e(route('user.services')); ?>" class="btn btn-primary mt-1 pulsating-btn" style="font-size: 15px"><?php echo e(__('Place new Order')); ?></a>
    <?php endif; ?>
  </div>
</div>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xm-12">
        <div class="card overflow-hidden border-0">
            <div class="card-header">
                <h3 class="card-title"><?php echo e(__('My Notifications')); ?></h3>
            </div>
            <div class="card-body pt-2">
                <!-- SET DATATABLE -->
                <table id='notificationsTable' class='table' width='100%'>
                    <thead>
                        <tr>
                            <th width="10%"><?php echo e(__('Type')); ?></th>
                            <th width="10%"><?php echo e(__('Received On')); ?></th>
                            <th width="10%"><?php echo e(__('User Action')); ?></th>
                            <th width="10%"><?php echo e(__('Sender')); ?></th>
                            <th width="20%"><?php echo e(__('Subject')); ?></th>
                            <th width="10%"><?php echo e(__('Read On')); ?></th>
                            <th width="5%"><?php echo e(__('Actions')); ?></th>
                        </tr>
                    </thead>
                </table> <!-- END SET DATATABLE -->
            </div>
        </div>
    </div>

  <!--  <div class="col-lg-4 col-md-4 col-xm-4">
        <div class="card overflow-hidden border-0">
            <div class="card-header">
                <h3 class="card-title"><?php echo e(__('My Referral Stats')); ?></h3>
            </div>
            <div class="card-body pt-2">
                <div class="input-box">
                    <h6 class="fs-12 font-weight-bold poppins"><?php echo e(__('My Referral URL')); ?></h6>
                    <div class="form-group d-flex referral-social-icons">
                        <input type="text" class="form-control" id="email" readonly value="<?php echo e(config('app.url')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>">
                        <div class="ml-2">
                            <a href="" class="btn create-project pb-2" id="actions-copy" data-link="<?php echo e(config('app.url')); ?>/?ref=<?php echo e(auth()->user()->referral_id); ?>" data-tippy-content="Copy Referral Link"><i class="fa fa-link"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row text-center justify-content-md-center">
						<div class="col-md-6 col-sm-12 referral-box special-shadow">
                        <h6 class="fs-10 font-weight-bold poppins"><?php echo e(__('My Earned Commissions')); ?></h6>							
								<p class="fs-12"><?php echo config('payment.default_system_currency_symbol'); ?><?php echo e(number_format((float)$total_commission[0]['data'], 2, '.', '')); ?> <?php echo e(config('payment.default_currency')); ?></p>
							</div>
						<div class="col-md-6 col-sm-12 referral-box special-shadow">
                        <h6 class="fs-10 font-weight-bold poppins"><?php echo e(__('Referral Commission Rate')); ?></h6>							
								<p class="fs-12"><?php echo e(config('payment.referral.payment.commission')); ?>%</p>
							</div>
						
					</div>

            </div>
        </div>
    </div> -->
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xm-12">
        <div class="card border-0">
			<div class="card-header">
                <h3 class="card-title"><?php echo e(__('My Order History')); ?></h3>
            </div>
            <div class="card-body pt-2">
                <!-- BOX CONTENT -->
                <div class="box-content">
                    <!-- DATATABLE -->
                    <div class="table-responsive-sm">
                        <table id='listUsersTable' class='table listUsersTable' width='100%'>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Service Type</th>
                                    <th>Posted</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                
                                  <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <a href=" <?php echo e(route('user.order_details')); ?>?id=<?php echo e($order->id); ?>">
                                        <?php echo e(__($order->id)); ?> 
                                    </a>

                                </td>
                                <td>
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('services')->where('id', $order->service_id)->first();
                                    echo $c->name;
                                    ?>
                                </td>

                                <td>
                                    <?php echo e(date('Y-m-d', strtotime($order->created_at))); ?>

                                </td>

                                <td>
                                    <?php echo e(date('Y-m-d', strtotime($order->dead_line))); ?> <?php echo e(date("h:i A", strtotime($order->deadline_time))); ?>

                              
                                </td>
                                <td>
                                    <?php
                                    $c = Illuminate\Support\Facades\DB::table('order_statuses')->where('id', $order->order_status_id)->first();
                                    echo $c->name;


                                    ?>
                                </td>
                                
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATATABLE -->
                </div> <!-- END BOX CONTENT -->
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<!-- Data Tables JS -->
<script src="<?php echo e(URL::asset('plugins/datatable/datatables.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('plugins/sweetalert/sweetalert2.all.min.js')); ?>"></script>
<script type="text/javascript">
    $(function () {

        "use strict";

        // INITILIZE DATATABLE
        var table = $('#notificationsTable').DataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
            responsive: true,
            colReorder: true,
            language: {
                "emptyTable": "<div><img id='no-results-img' src='<?php echo e(URL::asset('img/files/no-notification.png')); ?>'><br><?php echo e(__('There are no notifications for you yet')); ?></div>",
                search: "<i class='fa fa-search search-icon'></i>",
                lengthMenu: '_MENU_ ',
                paginate : {
                    first    : '<i class="fa fa-angle-double-left"></i>',
                    last     : '<i class="fa fa-angle-double-right"></i>',
                    previous : '<i class="fa fa-angle-left"></i>',
                    next     : '<i class="fa fa-angle-right"></i>'
                }
            },
            "order": [[ 1, "desc" ]],
            pagingType : 'full_numbers',
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('user.notifications')); ?>",
            columns: [{
                    data: 'notification-type',
                    name: 'notification-type',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'created-on',
                    name: 'created-on',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'user-action',
                    name: 'user-action',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'sender',
                    name: 'sender',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'subject',
                    name: 'subject',
                    render: $.fn.dataTable.render.text(),
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'read-on',
                    name: 'read-on',
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


        // DELETE CONFIRMATION 
        $(document).on('click', '.deleteNotificationButton', function(e) {

            e.preventDefault();

            Swal.fire({
                title: '<?php echo e(__('Confirm Notification Deletion')); ?>',
                text: '<?php echo e(__('It will permanently delete this notification')); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<?php echo e(__('Delete')); ?>',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData();
                    formData.append("id", $(this).attr('id'));
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        method: 'post',
                        url: 'notification/delete',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            if (data == 'success') {
                                Swal.fire('<?php echo e(__('Notification Deleted')); ?>', '<?php echo e(__('Notification has been successfully deleted')); ?>', 'success');
                                $("#notificationsTable").DataTable().ajax.reload();
                            } else {
                                Swal.fire('<?php echo e(__('Delete Failed')); ?>', '<?php echo e(__('There was an error while deleting this notification')); ?>', 'error');
                            }
                        },
                        error: function(data) {
                            Swal.fire({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
                        }
                    })
                }
            })
        });

    });
</script>
<!-- Link Share JS -->
<script src="<?php echo e(URL::asset('js/link-share.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/relaxed-nobel.35-229-252-74.plesk.page/httpdocs/resources/views/user/dashboard/index.blade.php ENDPATH**/ ?>