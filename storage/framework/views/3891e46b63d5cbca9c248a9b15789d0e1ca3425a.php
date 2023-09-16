<?php $__env->startComponent('mail::message'); ?>

Dear <?php echo e($user->name); ?>,

We noticed that the payment process for your recent order on My Perfect Writing was not completed.

Order Details: <br>
Order ID: #<?php echo e($order->id); ?> <br>
Order Date: <?php echo e($order->created_at); ?> <br>
Pending Payment: <?php echo e($order->amount); ?>


Finalizing your payment ensures that our team of dedicated writers and editors can commence work on your project and meet the promised delivery timelines.

To complete your payment:
1.	Log in to your account at myprefectwriting.co.uk.
2.	Navigate to 'My Unpaid Orders'.
3.	Locate Order ID #[OrderID] and select 'Complete Payment'.

Please be informed that an incomplete payment might lead to delays in processing your order or may result in order cancellation.

If you encountered any issues during the payment process or have any questions regarding your order, please don't hesitate to reach out to our customer support team. We're here to assist you every step of the way.

Thank you for choosing My Perfect Writing. Let's ensure your writing needs are met smoothly and promptly.


Warm Regards,
Client Support,
My Perfect Writing


<?php echo $__env->renderComponent(); ?> <?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/portal.myperfectwriting.co.uk/resources/views/emails/inCompletePayment.blade.php ENDPATH**/ ?>