<?php

namespace App\Http\Controllers\Product;

use Alert;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CompareController extends Controller
{
    protected $data = array();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $compare = session('compare');
        if($compare && count($compare) > 1){
            return view('pages.compare')->with(compact('compare'));
        } else {
            Alert::warning('Compare table needs at least two items!', 'Oops..!')->persistent("Close this");
            return redirect()->route('welcome');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function add(Request $request, Product $product)
    {
 
        $compare = session()->get('compare');

        if ($compare && count($compare) == 4) {
            $data = [
                'warning',
                'Maximum items reached in compare table!',
            ];
                
            return $this->sendResponse($request, $this->prepareResponseData($data));
        }

        if(isset($compare[$product->model])) {
            $data = [
                'warning',
                'Item already exists in your compare table!',
            ];
                
            return $this->sendResponse($request, $this->prepareResponseData($data));
        }

        $compare[$product->model] = $product;
        session()->put('compare', $compare);
        $data = [
                'success',
                'Item is added to your compare table.',
            ];
                
        return $this->sendResponse($request, $this->prepareResponseData($data));
    }

    public function destroy(Request $request, $model)
    {
        // if requested item is not in compare
        if (!$request->session()->exists('compare.'.$model)){
            abort(404);
        }

        $compare = session()->get('compare');
        unset($compare[$model]);
        session()->put('compare', $compare);

        if(count($compare) < 2){
            $data = [
                'warning',
                'Item is removed from compare table!',
            ];
                
            return $this->sendResponse($request, $this->prepareResponseData($data));
        }
        $data = [
                'success',
                'Item is removed from compare table!',
            ];
                
        return $this->sendResponse($request, $this->prepareResponseData($data));
    }

    protected function prepareResponseData($data = array()){
        $this->data['responseType'] = $data[0];
        $this->data['responseText'] = $data[1];

        if ($data[0] == 'success') {
            $this->data['responseTitle'] = ucfirst($data[0]);
        } elseif ($data[0] == 'warning') {
            $this->data['responseTitle'] = 'Oops..';
        }

        return $this->data;
    }

    protected function sendResponse($request, $data){

        if (request()->expectsJson()) {
            return [$data['responseType'] => $data['responseText']];
        }

        Alert::{$data['responseType']}($data['responseText'], $data['responseTtitle'])->persistent("Great!");
        return back();
    }
}
