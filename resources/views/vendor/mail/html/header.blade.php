<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img {{-- src="https://laravel.com/img/notification-logo.png" --}} src="{{ asset('img/acegroups.png') }}" class="logo" alt="AceClub Logo">
@else
<img {{-- src="https://laravel.com/img/notification-logo.png" --}} src="{{ asset('img/acegroups.png') }}" class="logo" alt="AceClub">
{{-- $slot --}}
@endif
</a>
</td>
</tr>
