@component('mail::message')

	<h2>Dear {{$reply->message->user->fullname()}},</h2><p>Thanks for being with {{ config('app.name') }} family.</p>
	<p>{{$reply->reply}}</p>
	<p>Please, mention the reference number as the subject of your erply when you reply to this mail.
	We hope you are enjoying shopping with <a href="{{route('welcome')}}">LogicBagBD</a>.</p>

	Thanks,<br>
	{{ config('app.name') }}

@endcomponent
