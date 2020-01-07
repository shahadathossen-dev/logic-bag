
@component('mail::message')

<h2>Hello<?php
	if($user->fname){
		echo ', '.$user->fname;
	}
	?>!</h2>

Welcome to {{ config('app.name') }} family.<br>
<br>
An account as 
			@if($user->role == 0)
              "{{ 'Master' }}"
            @elseif($user->role == 1)
              "{{ 'Admin' }}"
            @elseif($user->role == 2)
              "{{ 'Editor' }}"
            @elseif($user->role == 3)
              "{{ 'CSR' }}"
            @elseif($user->role == 4)
              "{{ 'Publisher' }}"
            @endif
has been just created for you.
To verify your email address and create your password please click the given link below.

@component('mail::button', ['url' => route('verifyEmail',['email' => $user->email,'verify_token' => $user->verify_token]),  'color' => 'success'])
Verify Email Address
@endcomponent

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}

{{-- Subcopy --}}
{{-- @isset($actionText) --}}
@component('mail::subcopy')
    @lang("If you’re having trouble clicking the 'Verify Email Address' button, copy and paste the URL below into your web browser: ")
	{{ route('verifyEmail', ['email' => $user->email, 'verify_token' => $user->verify_token]) }}
@endcomponent
{{-- @endisset --}}
{{-- Subcopy --}}

@endcomponent
