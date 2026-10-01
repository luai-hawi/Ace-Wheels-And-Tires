<x-mail::message>
    # New website lead

    **Name:** {{ $lead->name }}
    @if ($lead->email)
        **Email:** {{ $lead->email }}
    @endif
    @if ($lead->phone)
        **Phone:** {{ $lead->phone }}
    @endif
    @if ($lead->service_interested)
        **Interested in:** {{ $lead->service_interested }}
    @endif

    @if ($lead->message)
        **Message:**

        {{ $lead->message }}
    @endif

    <x-mail::button :url="url('/admin/leads')">
        View in admin panel
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
