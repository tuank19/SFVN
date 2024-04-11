<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\Invoice;
use App\Models\OrderDetail;
use App\Models\ProductAttribute;
use Illuminate\Http\Response;
use DB;

class InvoiceController extends Controller
{
    public function index(): View {
        $invoices = Invoice::all();
        return view('pages.invoice.index',['invoices'=>$invoices]);
    }

    public function view($id): View {
        $invoice =Invoice::with('order')->with('customer')->findOrFail($id);
        $city = DB::table('city')->where('id',$invoice->customer->city_id)->first();
        $district = DB::table('district')->where('id',$invoice->customer->district)->first();
        $ward = DB::table('ward')->where('id',$invoice->customer->ward_id)->first();
        $products = array();
        foreach($invoice->order->orderDetails as $detail)
        {
            $prod = $detail->product;

            $attrUnit =ProductAttribute::where('attr_slug','unit')->where('product_id',$prod->id)->first();
            $prodDetail =OrderDetail::where('product_id',$prod->id)->where('order_id',$invoice->order->id)->first();
            $prod->unit = $attrUnit;
            $prod->prodDetail = $prodDetail;
            $products[]= $prod;
        }
        return view('pages.invoice.detail',[
            'invoice'=> $invoice,
            'city'=>$city,
            'district'=>$district,
            'ward'=>$ward,
            'products'=>$products
        ]);
    }
}
