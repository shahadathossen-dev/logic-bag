
@component('mail::message')

<h2>Dear<?php
	if($customer){
		echo ', '.$customer->fname;
	}
	?>!</h2>

Welcome to {{ config('app.name') }} family.<br>
<br>
Thanks for verifying your account.
This is to inform you that your account on <a href="{{route('welcome')}}">LogicBagBD</a> just has been verified by you.
Your login credentials are being sent only to you for your future assistance respecting your data right. 

@component('mail::table')
	| Name       	| Value         		 |
	| ------------- |:----------------------:|
	| Email		    | {{$customer->email}}   |
	| Password      | {{$customer->password}}|
@endcomponent

Please, keep this credentials saved somewhere safe to avoid any sort of data peeping.
We hope you will be enjoying shopping with <a href="{{route('welcome')}}">LogicBagBD</a>.

Thanks,<br>
{{ config('app.name') }}

@slot('subcopy')
    @component('mail::subcopy')
        @endcomponentThis mail is being sent only to you for your future assistance respecting your data right. To learn more please visit our
        <a href='{{route('privacy.policy')}}' title='Privacy Policy'>privacy policy</a> page.
@endslot


@endcomponent

//New Order
@component('mail::message')
	<h2>Hello {{$notifiable->fname}}!</h2>Congratulations from {{ config('app.name') }} family.</br>

	This is to inform you that a new order just has been placed by {{$order->customer->fname.' '.$order->customer->lname}}.
	The order details are presented below for your further reference. Please, find the attachment of invoice creeated against this order.</br>

	@component('mail::table')
		| Name       	| Value         		 |
		| ------------- |:----------------------:|
		| Order Number		    | {{$order->order_number}}   |
		| Invoice Number      | {{$order->invoice->invoice_number}}|
	@endcomponent	
	
	All the informations are confidential and {{ config('app.name') }} reserves all the rights.
	Please, keep this credentials saved somewhere safe to avoid any sort of data peeping.
	We hope you will be enjoying working with <a href="{{route('welcome')}}">LogicBag</a> family.

	Thanks,<br>
	{{ config('app.name') }}
	
@endcomponent