<?php $__env->startComponent('mail::message'); ?>
# <?php echo e($input->subject); ?>


<?php echo e($input->message); ?>


Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/emails/test.blade.php ENDPATH**/ ?>