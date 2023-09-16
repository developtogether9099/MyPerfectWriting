@component('mail::message')

Dear {{$user->name}},

We are excited to share that your order has been reviewed and assigned to one of our expert writers!

Order Details: <br>
Order ID: #{{$order->id}} <br>
Order Date: {{$order->created_at}}

Writer's Name: {{$writer->username}}

Our team at My Perfect Writing is a blend of experienced and talented individuals, and we've ensured that your project is entrusted to a writer who has expertise in your specific domain or topic. With this assignment, your order is now actively in progress.

We understand the anticipation of waiting for a piece of work, especially when it's crucial for you. You can track the development of your order anytime by logging into your account at myprefectwriting.co.uk and heading to the ‘My Orders’ section.

Thank you for trusting My Perfect Writing. We appreciate your patience and assure you of a timely and top-notch delivery.

Warm Regards,
Client Support,
My Perfect Writing


@endcomponent 