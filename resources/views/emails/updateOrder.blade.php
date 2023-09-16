@component('mail::message')

# Your Order has been updated successfully and placed at {{ config('app.name') }} 

Thanks,<br>

{{ config('app.name') }}

@endcomponent 