<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo e(__('Suppor Ticket Information')); ?></title>
</head>
<body>
	<p>
		<?php echo e(__('Thank you')); ?> <?php echo e(ucfirst($user->name)); ?> <?php echo e(__('for contacting our support team. A support ticket has been opened for you. You will be notified when a response is made by email. The details of your ticket are shown below')); ?>:
	</p>

	<p><?php echo e(__('Title')); ?>: <?php echo e($ticket->subject); ?></p>
	<p><?php echo e(__('Priority')); ?>: <?php echo e($ticket->priority); ?></p>
	<p><?php echo e(__('Status')); ?>: <?php echo e($ticket->status); ?></p>

	<p>
		<?php echo e(__('Login to your account to check the status of your support ticket')); ?>

	</p>

</body>
</html><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/admin/emails/support_ticket_info.blade.php ENDPATH**/ ?>