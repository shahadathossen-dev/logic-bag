<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Report;
use App\Http\Controllers\Controller;

class ReportController extends Controller
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

    public function show ($model)
    {
        $report = Report::whereModel($model)->first();
        return view('backend.pages.products.reports.show')->with(compact('report'));
    }

}
