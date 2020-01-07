@component('mail::message')
	<h2>Hello, {{$customer ? $customer->fname : 'Dear'}}!</h2>Welcome to {{ config('app.name') }} family.<br>
	Thanks for verifying your account.
	This is to inform you that your account on <a href="{{route('welcome')}}">LogicBagBD</a> just has been verified by you.
	Your login credentials are being sent only to you for your future assistance respecting your data right.<br>
	@component('mail::table')
		| Name       	| Value         		 			|
		| ------------- |:---------------------------------:|
		| Email		    | {{$customer->email}}  			|
		| Password      | {{$customer->palain_password}}  	|
	@endcomponent	
	Please, keep this credentials saved somewhere safe to avoid any sort of data peeping.
	We hope you will be enjoying shopping with <a href="{{route('welcome')}}">LogicBagBD</a>.

	Thanks,<br>
	{{ config('app.name') }}

@endcomponent
