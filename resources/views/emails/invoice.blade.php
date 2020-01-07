<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<title>{{ config('app.name') }} - Invoice</title>

	<link href="https://fonts.googleapis.com/css?family=Tinos:400,700" rel="stylesheet">

	<style type="text/css">
		@font-face {
		  	/*font-family: 'Tinos', Serif;*/
		  	/*src: url('https://fonts.googleapis.com/css?family=Tinos:400,700') format('truetype');*/
		  	/*font-style: normal;
		  	font-weight: normal;*/
		}
		
		.page-break {
		    page-break-after: always;
		}

		@page {
            margin: 72px;
        }

		body {
			font-family: "Tinos", Serif;
			font-weight: 400;
			font-size: 13px;	
		}
		
		.top-bar {
			width: 100%;
			margin-bottom: 20px;
		}
		
		.company {
			width: 50%;
			display: inline-block;
		}
		
		.logo, .payment-methods img {
			display: inline;
			width: 30px;
			vertical-align: baseline;
		}

		.company .name {
			font-weight: bold;
			font-size: 20px;
			line-height: 25px;
			vertical-align: middle;
		}

		.date {
			text-align: right;
			width: 50%;
			display: inline-block;
		}
		
		.title-section {
			width: 200px;
			margin: 0 auto;
			font-size: 25px;
			font-weight: bold;
			text-align: center;	
			border: 1px solid;
			border-radius: 5px;
			background-color: lightGrey;
		}

		.address-section {
			width: 100%;
		}

		.from, .to, .invoice {
			display: inline-block;
			width: 33%;
		}

		.items-section {
			width: 90%;
			margin: 0 auto;
			/*margin-bottom: 30px;*/
		}

		.items-section h1 {
			width: 200px;
			margin: 0 auto;
			border: 1px solid;
			border-radius: 5px;
			text-align: center;	
			background-color: lightGrey;
		}

		.items-section table {
			width: 100%;
			border: 1px solid;
			margin: 10px auto;
			border-collapse: collapse;
			text-align: center;	
		}

		.items-section th {
			background-color: lightGrey;
			border-top: 1px solid;
			border-bottom: 1px solid;
		}

		.items-section th, .items-section td {
			border-left: 1px dashed;
			border-right: 1px dashed;
		}
		
		.payment-section {
			width: 100%;
			margin-top: 40px;
		}

		.payment-methods, .payment-summary, .authorized, .customer {
		  width: 50%;
		  display: inline-block;
		}

		.payment-methods img:first-child {
			margin-left: 20px;
		}
		
		.payment-summary table {
			width: 100%;
			border-collapse: collapse;
		}

		.payment-summary th {
			background-color: lightGrey;
		}

		.payment-summary th, .payment-summary td {
			border-bottom: 1px solid lightGrey;
		}
		
		.value {
			text-align: right; font-weight: bold;
		}
		
		.signature-section {
			text-align: center;
			width: 90%;
			margin: 0px auto;
		}

		.authorized {
			text-align: left;
		}

		.customer {
			text-align: right;
		}

		.authorized p, .customer p {
		  border-top: 1px solid;
		  display: inline;
		}

	</style>
</head>
<body>
	<div class="top-bar">
		<div class="company">
			<span class="name">{{config('app.name')}}</span>
			<img class="logo" src="{{public_path('/resource/img/icons/favicon.png')}}"  alt="LogicBag-logo">
		</div>

		<div class="date">Date: {{Illuminate\Support\Carbon::today()->format('d-m-Y')}}</div>
	</div>
	
	{{-- <div class="title-section">
		INVOICE
	</div><br><br> --}}

	<div class="address-section">
		<div class="from">
			From<br>
			<span class="title"><strong>{{config('app.name')}}</strong></span><br>
			<span>
				Chowrongi Bhaban (4th floor),<br>
				124/A, New Elephant Road,<br>
				Dhaka-1205. Phone: 01847-277630<br>
				Email: {{'info@logicbag.com.bd'}}<br>
			</span>
		</div>
		<div class="to">
			To<br>
			<span class="title"><strong>{{$invoice->order->billingAddress->name()}}</strong></span><br>
			<span>
				{{$invoice->order->billingAddress->street_address}},<br>
				{{$invoice->order->billingAddress->union}}, {{$invoice->order->billingAddress->city}}-{{$invoice->order->billingAddress->zipcode}},<br>
				Phone: {{$invoice->order->billingAddress->phone}}<br>
				Email: {{$invoice->order->billingAddress->email}}<br>
			</span>
		</div>
		<div class="invoice">
			<span class="invoice_number"><strong>Invoice Number:</strong> {{$invoice->invoice_number}}</span><br><br>
			<span class="order_id"><strong>Order ID:</strong> {{$invoice->order_number}}</span><br>
			<span class="order_date"><strong>Order Date:</strong> {{$invoice->order->created_at->format('d-m-Y')}}</span><br>
			<span class="payment_mode"><strong>Payment Mode:</strong> {{$invoice->order->paymentMode->mode}}</span><br>
		</div>
	</div>
	
	<div class="items-section">
		<h1>INVOICE</h1>
		<table>
			<colgroup>
				<col class="serial">
				<col class="title">
				<col class="model">
				<col class="color">
				<col class="quantity">
				<col class="rate">
				<col class="subtotal">
			</colgroup>
			<thead>
				<tr>
					<th width="5%">Sl.</th>
					<th width="45%">Item</th>
					<th width="10%">Model</th>
					<th width="10%">Color</th>
					<th width="10%">Quantity</th>
					<th width="10%">Unit Rate</th>
					<th width="10%">Subtotal</th>
				</tr>
			</thead>
			<tbody>
				@php
                    $sl = $price = $subTotal = $deliveryFee = 0;
                @endphp
                @foreach ($invoice->order->items as $item)
                @php
                    $price = ($item->quantity * $item->price);
                    $deliveryFee += ($item->quantity * 100);
                    $subTotal += $price;
                    $sl += 1;
                @endphp
                <tr>
                    <td>{{sprintf('%02d', $sl)}}</td>
                    <td style="text-align: left;">{{$item->product->title}}</td>
                    <td>{{$item->model}}</td>
                    <td>{{$item->variant->color}}</td>
                    <td>{{$item->quantity}}</td>
                    <td style="text-align: right;">{{number_format($item->price, 2)}}</td>
                    <td style="text-align: right; font-weight: bold;">{{number_format($price, 2)}}</td>
                </tr>
                @endforeach
                <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
			</tbody>
			<tfoot>
				 @php
                    $tax = ($subTotal * 0.05);
                    $shipping = 100;
                    $grandTotal = $subTotal + $tax + $shipping;
                    $due = $grandTotal - $invoice->payment;
                @endphp
                <tr>
                    <th colspan="5" class="value">Subtotal</th>
                    <th colspan="2" class="value">{{number_format($subTotal, 2)}}</th>
                </tr>
                <tr>
                    <th colspan="5" class="value">{{'Tax (0.5%)'}}</th>
                    <th colspan="2" class="value">{{number_format($tax, 2)}}</th>
                </tr>
                <tr>
                    <th colspan="5" class="value">{{'Delivery Fee'}}</th>
                    <th colspan="2" class="value">{{number_format(100, 2)}}</th>
                </tr>
                <tr>
                    <th colspan="5" class="value">{{'Grand Total'}}</th>
                    <th colspan="2" class="value">{{number_format($grandTotal, 2)}}</th>
                </tr>
			</tfoot>
		</table>
	</div>

	<div class="payment-section">
		<div class="payment-methods">
			<p>Payment Methods:</p>
			<img title="Master card" src="{{public_path('/backend/img/credit/mastercard.png')}}"  alt="Master card">
            <img title="Paypal" src="{{public_path('/backend/img/credit/paypal2.png')}}"  alt="Paypal">
            <img title="Visa" src="{{public_path('/backend/img/credit/visa.png')}}"  alt="Visa">
            <img title="Bkash" src="{{public_path('/backend/img/credit/bkash.jpg')}}"  alt="Bkash">
            <img title="Cash on Delivery" src="{{public_path('/backend/img/credit/cash.png')}}"  alt="Cash on Delivery"><br><br>

			<p>Pay full cash after you have received the product in hand and ensured that the delivered product is appropriate.</p>
		</div>
		<div class="payment-summary">
			<table>
				<thead>
					<tr>
						<th>Payment Due Date</th>
						<th class="value">{{$invoice->created_at->format('d-m-Y')}}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="text-align: left;">{{'Bill Amount'}}</td>
						<td class="value">{{number_format($grandTotal, 2)}}</td>
					</tr>
					<tr>
						<td style="text-align: left;">{{'Paid Amount'}}</td>
                        <td class="value">{{number_format($invoice->payment, 2)}}</td>
					</tr>
					<tr>
						<td style="text-align: left;">{{'Due Amount'}}</td>
						<td class="value">{{number_format($due, 2)}}</td>
					</tr>
				</tbody>
				<tfoot>
					{{-- <tr>
						<td style="text-align: left;">{{'Grand Total'}}</td>
                        <td class="value">{{number_format($due, 2)}}</td>
					</tr> --}}
				</tfoot>
			</table>
		</div>		
	</div>
	<div class="signature-section">
        <div class="authorized">
        	<p>Authorized Signature</p>
        </div>
        <div class="customer">
	        <p>Customer's Signature</p>
	    </div>
    </div>

</body>
</html>


