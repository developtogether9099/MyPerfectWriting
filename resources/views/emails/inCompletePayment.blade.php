@component('mail::message')

Dear {{$user->name}},

We noticed that the payment process for your recent order on My Perfect Writing was not completed.

Order Details: <br>
Order ID: #{{$order->id}} <br>
Order Date: {{$order->created_at}} <br>
Pending Payment: {{$order->amount}}

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


@endcomponent 