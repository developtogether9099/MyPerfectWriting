<?php $__env->startComponent('mail::message'); ?>
# Contact Us Request Submitted

Customer Name: <?php echo e($input->name); ?> <?php echo e($input->lastname); ?>


Customer Contacts: <br>
Email: <?php echo e($input->email); ?> 
Phone: <?php echo e($input->phone); ?>


Customer message: <br>
<?php echo e($input->message); ?>



Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/emails/contact.blade.php ENDPATH**/ ?>