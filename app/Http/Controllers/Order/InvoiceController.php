<?php

namespace App\Http\Controllers\Order;

use PDF;
use Alert;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Models\Orders\Invoice;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    protected function validator(array $data, $id = NULL)
    {
        return Validator::make($data, [
		    'sku'       => 'required|string|unique:attributes,sku,'.$id.',id',
		    'color'     => 'required|string',
		    'meta_color'     => 'required|string',
		    'stock'     => 'required|integer',
		    'images'    => 'required|array|max:10',
		    'images.*'  => 'string|distinct',
        ]);
	}

    public function show(Invoice $invoice)
    {
        $filename = $invoice->invoice_number;
        return view('backend.pages.orders.invoices.show', compact('invoice'));
    }

    public function export(Invoice $invoice)
    {
        $filename = $invoice->invoice_number;
        return PDF::loadView('pdf.invoice', compact('invoice'))->setOptions(['isHtml5ParserEnabled' => true])->stream($filename.'.pdf', array("Attachment" => 0));
    }

}
