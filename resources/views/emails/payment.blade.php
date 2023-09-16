@component('mail::message')

Dear {{$user->name}},

Thank you for your promptness. We're pleased to confirm that we have successfully received your payment for the following order.

Order Details: <br>
Order ID: #{{$order->id}} <br>
Order Date: {{$order->created_at}}
Payment Amount: {{$order->amount}}

With the payment successfully processed, our team will now prioritize and ensure that your order is executed according to the specified instructions and timelines. We're committed to delivering the highest quality, and your timely payment assists us in upholding that promise.

You can always track the progress of your order by logging into your account at myprefectwriting.co.uk and navigating to the ‘My Orders’ section.

Should you have any questions or require further clarification on any aspect of your order or payment, our dedicated customer support team is available to assist you. Remember to always reference your Order ID for a streamlined communication process.

Thank you for your trust in My Perfect Writing. We value your business and strive to meet and exceed your expectations.

Warm Regards,
Billing & Customer Relations,
My Perfect Writing



@endcomponent 