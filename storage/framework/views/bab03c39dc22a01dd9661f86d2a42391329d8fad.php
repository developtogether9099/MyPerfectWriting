<?php $__env->startSection('css'); ?>
    <!-- Data Table CSS -->
    <link href="<?php echo e(asset('plugins/datatable/datatables.min.css')); ?>" rel="stylesheet">
    <!-- Sweet Alert CSS -->
    <link href="<?php echo e(asset('plugins/sweetalert/sweetalert2.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <!-- PAGE HEADER -->
    <div class="page-header mt-5-7">
        <div class="page-leftheader">
            <h4 class="page-title mb-0"><?php echo e(__('Currency Rate')); ?></h4>
        </div>
    </div>
    <!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form role="form" class="form-horizontal" enctype="multipart/form-data"
          action="<?php echo e(route('admin.update_currency_rates')); ?>" method="post" autocomplete="off">
        <?php echo e(csrf_field()); ?>


        <div class="row mt-3">
            <div class="form-group col-lg-5">
                <label for="pound">UK Pound <span class="required">*</span></label>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control" name="pound" id="pound" readonly
                           value="<?php echo e($data->gb); ?>">
                    <i style="font-size:26px; margin-left:-30px" class="fas fa-pound-sign"></i>
                </div>
            </div>
            <div class="col-lg-2 mt-4 text-center">
                <h2>=</h2>
            </div>
            <div class="form-group col-lg-5">
                <label for="dollar">US Dollar <span class="required">*</span></label>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control" required name="dollar" id="dollar"
                           value="<?php echo e($data->usd); ?>">
                    <i style="font-size:26px; margin-left:-30px" class="fas fa-dollar-sign"></i>
                </div>
            </div>
            <div class="form-group col-lg-12 mt-3">
                <button class="btn btn-primary f-w-bold p-2 btn-block">Submit</button>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('innerPageJS'); ?>
    <script>
        $(function () {
            $('.selectPickerWithoutSearch').select2({
                theme: 'bootstrap4',
                minimumResultsForSearch: -1
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/admin/currency/currency_rates.blade.php ENDPATH**/ ?>