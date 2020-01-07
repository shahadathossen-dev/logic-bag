<?php

namespace App\Http\Controllers;

use PDF;
use Alert;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Orders\Invoice;
use Illuminate\Support\Carbon;
use App\Models\Product\Attribute;
use App\Models\Frontend\Customer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\Backend\NewOrderPlaced;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function check_out(Request $request)
    {
    	$cart = Session::get('cart');

        if(!$cart || count($cart) < 1){

            if ($request->ajax()) {
                abort(404);
            }

            Alert::warning('No item found in your cart', 'Oops..!')->persistent("Close this");
            return redirect()->route('welcome');
        }

        return view('pages.checkout')->with(compact('cart'));
    }

    protected function validator(array $data, $id = NULL)
    {
        return Validator::make($data, [
            'bill-fname'    => 'required|string|max:30',
            'bill-lname'    => 'required|string|max:30',
            'bill-email'    => 'required|email',
            'bill-address'  => 'required|string|max:60',
            'bill-union'    => 'required|string|max:30',
            'bill-zipcode'  => 'required|integer',
            'bill-city'     => 'required|string|max:30',
            'bill-country'  => 'required|string|max:30',
            'bill-phone'      => 'required',
            'ship'          => 'required|boolean',
            'order-note'    => ['string', function ($attribute, $value, $fail) {
                                $words = explode(' ', $value);
                                $nbWords = count($words);
                                if($nbWords < 50){
                                    $fail('The '.$attribute.' must be at least 50 words.');
                                }
                            }], 
        ]);
    }

    protected function shipValidator(array $data, $id = NULL)
    {
        return Validator::make($data, [
            'bill-fname'    => 'required|string|max:30',
            'bill-lname'    => 'required|string|max:30',
            'bill-email'    => 'required|email',
            'bill-address'  => 'required|string|max:60',
            'bill-union'    => 'required|string|max:30',
            'bill-zipcode'  => 'required|integer',
            'bill-city'     => 'required|string|max:30',
            'bill-country'  => 'required|string|max:30',
            'bill-phone'      => 'required',
            'ship'          => 'required|boolean',
            
            'ship-fname'    => 'required|string|max:30',
            'ship-lname'    => 'required|string|max:30',
            'ship-email'    => 'required|email',
            'ship-address'  => 'required|string|max:60',
            'ship-union'    => 'required|string|max:30',
            'ship-zipcode'  => 'required|integer',
            'ship-city'     => 'required|string|max:30',
            'ship-country'  => 'required|string|max:30',
            'ship-phone'      => 'required',
            'order-note'    => ['string', function ($attribute, $value, $fail) {
                                $words = explode(' ', $value);
                                $nbWords = count($words);
                                if($nbWords < 50){
                                    $fail('The '.$attribute.' must be at least 50 words.');
                                }
                            }], 
        ]);
    }

    public function place_order(Request $request)
    {
        if($request->ship){
            $this->shipValidator($request->all())->validate();
        } else {
            $this->validator($request->all())->validate();
        }

        $billingAddress = Auth::guard()->user()
                            ->billingAddresses()
                            ->firstOrCreate(
                                [
                                    'fname' => $request->{'bill-fname'},
                                    'lname' => $request->{'bill-lname'},
                                    'email' => $request->{'bill-email'},
                                    'street_address' => $request->{'bill-address'},
                                    'zipcode' => $request->{'bill-zipcode'},
                                ],
                                [
                                    'union' => $request->{'bill-union'},
                                    'city' => $request->{'bill-city'},
                                    'country' => $request->{'bill-country'},
                                    'phone' => $request->{'bill-phone'},
                                ]
                            );
        if($request->ship){
            $deliveryAddress = Auth::guard()->user()
                                ->deliveryAddresses()
                                ->firstOrCreate(
                                    [
                                        'fname' => $request->{'ship-fname'},
                                        'lname' => $request->{'ship-lname'},
                                        'email' => $request->{'ship-email'},
                                        'street_address' => $request->{'ship-address'},
                                        'zipcode' => $request->{'ship-zipcode'},
                                    ],
                                    [
                                        'union' => $request->{'ship-union'},
                                        'city' => $request->{'ship-city'},
                                        'country' => $request->{'ship-country'},
                                        'phone' => $request->{'ship-phone'},
                                    ]
                                );
        } else {
            $deliveryAddress = Auth::guard()->user()
                                ->deliveryAddresses()
                                ->firstOrCreate(
                                    [
                                        'fname' => $request->{'bill-fname'},
                                        'lname' => $request->{'bill-lname'},
                                        'email' => $request->{'bill-email'},
                                        'street_address' => $request->{'bill-address'},
                                        'zipcode' => $request->{'bill-zipcode'},
                                    ],
                                    [
                                        'union' => $request->{'bill-union'},
                                        'city' => $request->{'bill-city'},
                                        'country' => $request->{'bill-country'},
                                        'phone' => $request->{'bill-phone'},
                                    ]
                                );
        }
        
        $newOrder = Auth::guard()->user()->orders()->create([
            'offer_id' => $request->offer_id,
            'order_number' => $this->getNextOrderNumber(),
            'billing_address_id' => $billingAddress->id,
            'delivery_address_id' => $deliveryAddress->id,
            'payment_mode' => $request->{'payment-mode'},
            'delivery_date' => $this->getDeliveryDate(),
            'note' => $request->note,
        ]);

        if ($bill = $this->createOrderItems($newOrder)){
            $newInvoice = $newOrder->invoice()->create([
                'invoice_number' => $this->getNextInvoiceNumber(),
                'order_number' => $newOrder->number,
                'bill' => $bill,
            ]);

            event(new NewOrderPlaced($newOrder));

            if ($request->expectsJson()) {
                return ['warning' => 'New order has been placed successfully.'];
            }

            Alert::success('New order has been placed successfully.', 'Success')->persistent("Close this");
            Session::forget('cart');
            return redirect('/');
        }
        
    }

    public function index ()
    {
        $orders = Order::all();
        return view('backend.pages.orders.index')->with(compact('orders'));
    }

    public function history (Request $request)
    {
        $user = Auth::guard()->user();
        $orders = $user->orders();
        $orders = $user->orders()->paginate(5);
        if(!$orders || count($orders) < 1){
        
            if ($request->ajax()) {
                abort(404);
            }

            Alert::warning('No order found in your order history!', 'Oops..!')->persistent("Close this");
            return redirect()->route('welcome');
        }
        
        if ($request->ajax()) {
            return view('pages.partials.order-table')->with(compact('orders'));
        }

        return view('pages.user.orders.index')->with(compact('orders'));
    }

    public function show(Order $order)
    {
        return view('pages.user.orders.show')->with(compact('order'));
    }

    public function update(Request $request)
    {
        $order = Order::findOrFail($request->order);
        $update = $order->update([
                'status_id' => $request->status
            ]);

        if ($update) {
            Alert::success('Order status has been updated successfully.', 'Success')->persistent("Close this");
            return back();
        }
    }

    public function cancel(Order $order)
    {
        if (Auth::guard()->user()->hasOrder($order->order_number)) {
            if ($order->isCancellable()) {

                $update = $order->update(
                    [
                        'status_id' => 2
                    ]);

                if ($update) {
                    Alert::success('Order has been cancelled successfully.', 'Success')->persistent("Close this");
                    return redirect()->route('user.order.history');
                }
            } else {
                Alert::warning('Order grace period is over.', 'Oops!')->persistent("Close this");
                return redirect()->route('user.order.history');
            }

        } else {
            Alert::warning('Order not found.', 'Oops!')->persistent("Close this");
            return redirect()->route('user.order.history');
        }
    }

    protected function createOrderItems($newOrder)
    {
        $cart = Session::get('cart');
        $bill = 0;
        foreach($cart as $model => $productModel){
            foreach($productModel as $sku => $item){
                $product = Product::whereModel($item->model)->firstOrFail();
                $subtotal = $item->price * $item->quantity;
                $newOrder->items()->create([
                            'order_number' => $newOrder->order_number,
                            'model' => $item->model,
                            'attribute' => $item->attribute['sku'],
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'total' => $subtotal
                ]);

                $bill += $subtotal;
                $product->update_sales($item->quantity, $subtotal);
            }
        }

        return $bill;
    }  

    protected function getNextOrderNumber()
    {
        // Get the last created order
        $lastOrder = DB::table('orders')->orderBy('created_at', 'desc')->first();

        if ( ! $lastOrder )
            // We get here if there is no order at all
            // If there is no number set it to 0, which will be 1 at the end.

            $number = 0;
        else 
            $number = substr($lastOrder->order_number, 3);

        // If we have ORD000001 in the database then we only want the number
        // So the substr returns this 000001

        // Add the string in front and higher up the number.
        // the %05d part makes sure that there are always 6 numbers in the string.
        // so it adds the missing zero's when needed.
     
        return 'ORD' . sprintf('%06d', intval($number) + 1);
    }

    protected function getNextInvoiceNumber()
    {
        // Get the last created order
        $lastInvoice = DB::table('invoices')->orderBy('created_at', 'desc')->first();

        if ( ! $lastInvoice )
            // We get here if there is no order at all
            // If there is no number set it to 0, which will be 1 at the end.

            $number = 0;
        else 
            $number = substr($lastInvoice->invoice_number, 3);

        // If we have ORD000001 in the database then we only want the number
        // So the substr returns this 000001

        // Add the string in front and higher up the number.
        // the %05d part makes sure that there are always 6 numbers in the string.
        // so it adds the missing zero's when needed.
     
        return 'INV' . sprintf('%06d', intval($number) + 1);
    }

    protected function getDeliveryDate()
    {
        $next = 3;
        $friday = Carbon::parse('next friday');
        $deliveryDate = Carbon::today()->addDays($next);
        
        if ($friday <= $deliveryDate) {
            $deliveryDate->day++;
        }

        if($deliveryDate->isPast()){
            $deliveryDate->month++;
        }

        return $deliveryDate;
    }

}
