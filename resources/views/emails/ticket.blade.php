{{-- ticket.blade --}}

@component('mail::message')
# Your Ticket is Ready!

Dear {{ $booking->user->name }},

Thank you for booking with EZ-Bus. Your ticket is attached below as a PDF.

@component('mail::button', ['url' => 'https://yourapp.com'])
Go to Website
@endcomponent

Thanks,<br>
EzBus Team
@endcomponent
