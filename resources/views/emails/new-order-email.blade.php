@component('mail::message')
	<h2>Hello {{$notifiable->fname}}!</h2>Congratulations from {{ config('app.name') }} family.<br>

	This is to inform you that a new order just has been placed by {{$order->customer->fname}}.
	The order details are presented below for your further reference.<br><br>
	Order Number	:<span style="float: right">{{$order->order_number}}</span><br>
	Invoice Number	:<span style="float: right">{{$order->invoice->invoice_number}}</span><br>
	Order Date	:<span style="float: right">{{date('jS F, Y', strtotime($order->created_at))}}</span><br>
	Delivery Date	:<span style="float: right">{{date('jS F, Y', strtotime($order->delivery_date))}}</span><br>
	@component('mail::table')
		| Item Name       			| Model         		 | Color         		 | Quantity         	 | Price         		 |
		|:---------------------:|:----------------------:|:---------------------:|:---------------------:|:---------------------:|
		 @foreach ($order->items as $item)
			| {{$item->product->title}} | {{$item->model}} | {{$item->variant->color}} | {{$item->quantity}} | {{number_format($item->total, 2)}}|
		@endforeach
		| <span style="font-weight: bold;">Total</span> | | | | <span style="text-align: right; font-weight: bold;">{{number_format($order->invoice->bill, 2)}}</span>   |
		
		
	@endcomponent	
	
	All the informations are confidential and {{ config('app.name') }} reserves all the rights.
	Please, keep this credentials saved somewhere safe to avoid any sort of data peeping.
	We hope you will be enjoying working with <a href="{{route('welcome')}}">LogicBag</a> family.<br>

	Thanks & Regards,<br>
	{{ config('app.name') }}
	
@endcomponent
