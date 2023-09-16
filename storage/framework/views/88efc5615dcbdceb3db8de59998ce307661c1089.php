<?php $__env->startComponent('mail::message'); ?>

Dear <?php echo e($user->name); ?>,

We are excited to share that your order has been reviewed and assigned to one of our expert writers!

Order Details: <br>
Order ID: #<?php echo e($order->id); ?> <br>
Order Date: <?php echo e($order->created_at); ?> <br>
Completion Date: <?php echo e($order->updated_at); ?>


Your final document(s) is now available for download in your client portal. To access it:
1.	Log in to your account at myprefectwriting.co.uk.
2.	Navigate to 'My Orders' 
3.	Locate Order ID #[OrderID] and select 'Download'.

We are dedicated to ensuring the utmost satisfaction with our services. Therefore, after reviewing your completed order, please do let us know if there are any adjustments or revisions needed. Our team is here to assist you.

Feedback is a cornerstone of our continuous improvement. We kindly ask you to take a moment to share your experience with us. Whether it's words of appreciation or areas of improvement, your insights are invaluable.

Thank you for choosing My Perfect Writing. We're honored to have been a part of your writing journey and look forward to serving you again.

Best Regards,
Customer Support,
My Perfect Writing


Warm Regards,
Client Support,
My Perfect Writing


<?php echo $__env->renderComponent(); ?> <?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/emails/completeOrder.blade.php ENDPATH**/ ?>