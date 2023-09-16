<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo e(__('Suppor Ticket Status')); ?></title>
</head>
<body>
	<p>
		<?php echo e(__('Hello')); ?> <?php echo e(ucfirst($ticketOwner->name)); ?>,
	</p>
	<p>
		<?php echo e(__('Your support ticket with ID')); ?> #<?php echo e($ticket->ticket_id); ?> <?php echo e(__('has been marked has resolved or closed')); ?>.
	</p>
</body>
</html><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/admin/emails/support_ticket_status.blade.php ENDPATH**/ ?>