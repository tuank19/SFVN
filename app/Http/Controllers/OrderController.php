<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Category;
use App\Models\Invoice;
use Carbon\Carbon;
use App\Http\Requests\OrderRequest;

use DB;

class OrderController extends Controller
{
    public function index(): View {
        $orders = Order::all();
        return view ('pages.order.index',['orders'=>$orders]);
    }

    public function create(): View {
        $customers = Customer::all();
        $orderDate = Carbon::now();
        $city = DB::table('city')->get();
        $orderStatus = 'pending';
        $orderNumber = 'ORD' . date('Y') . rand(1000, 9999);
        $cats = Category::all();
        return view('pages.order.create',['customers'=>$customers,
            'orderDate'=>$orderDate,
            'orderStatus'=>$orderStatus,
            'orderNumber'=>$orderNumber,
            'city'=>$city,
            'cats'=>$cats
        ]);
    }

    public function submitCreateOrder(OrderRequest $request): Response {
        $order = new Order;
        $orderDateTimestamp = strtotime($request->orderDate);
        $orderDateFormatted = date('Y-m-d', $orderDateTimestamp);
        $order->order_number = $request->orderNumber;
        $customer = Customer::where('uuid', $request->customerUUID)->first();
        $order->customer_id = $customer->id;
        $order->order_date = $orderDateFormatted;
        $order->status = $request->orderStatus;
        $order->save();
        $productData = json_decode($request->data, true);
        $totalAmount = 0;
        foreach ($productData as $key => $quantity) {
            $prod = Product::where('uuid', $key)->first();
            $orderDetail = new OrderDetail;
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $prod->id;
            $orderDetail->quantity = $quantity;
            $orderDetail->price = $quantity * $prod->price;
            $totalAmount += $quantity * $prod->price;
            $orderDetail->save();
         }
         $invoice = new Invoice;
         $invoice->order_id = $order->id;
         $invoice->customer_id = $customer->id;
         $invoice->invoice_date=now();
         $invoice->total_amount=$totalAmount;
         $invoice->save();

        return Response(['code'=>200 , 'message'=>'Thành công', 'invoice'=>$invoice ],200);

    }

    public function edit($orderNumber): View {
        $order = Order::where('order_number', $orderNumber)->with('customer')->with('orderDetails')->first();
        $orderDetails = $order->orderDetails;
        $products = [];
        $dataProducts=[];
        foreach($orderDetails as $orderDetail) {
            $p=Product::where('id',$orderDetail->product_id)->with('category')->first();
            $attrUnit = ProductAttribute::where('attr_slug','unit')->where('product_id', $orderDetail->product_id)->first();
            $p->unit = $attrUnit;
            $dataProducts[]=$p;
            $products[$p->uuid] = $orderDetail->quantity;
        }
        $customers = Customer::all();
        $cats = Category::all();
        $city = DB::table('city')->get();
        $wardCurrent = DB::table('ward')->where('id', $order->customer->ward_id)->first();
        $districtCurrent = DB::table('district')->where('id', $order->customer->district)->first();
        $cityCurrent = DB::table('city')->where('id', $order->customer->city_id)->first();
        return view('pages.order.edit', [
            'order'=>$order,
            'customers'=>$customers,
            'cats'=>$cats,
            'city'=>$city,
            'wardCurrent'=>$wardCurrent,
            'districtCurrent'=>$districtCurrent,
            'cityCurrent'=>$cityCurrent,
            'products'=>$products,
            'dataProducts'=>$dataProducts
        ]);
    }

    public function submitEdit(Request $request, $orderNumber): Response {
        $order = Order::where('order_number', $orderNumber)->with('customer')->first();
        $customer = Customer::where('uuid', $request->customerUUID)->first();
        if($customer->id != $order->customer->id) {
            $order->customer_id = $customer->id;
        }
        $order->status = $request->orderStatus;
        $order->save();
        $productData = json_decode($request->data, true);
        $totalAmount = 0;
        OrderDetail::where('order_id',$order->id)->delete();
        foreach ($productData as $key => $quantity) {
            $prod = Product::where('uuid', $key)->first();
            $orderDetail = new OrderDetail;
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $prod->id;
            $orderDetail->quantity = $quantity;
            $orderDetail->price = $quantity * $prod->price;
            $totalAmount += $quantity * $prod->price;
            $orderDetail->save();
        }
        $invoice = Invoice::where('order_id',$order->id)->first();
        if($customer->id != $invoice->customer->id) {
            $invoice->customer_id = $customer->id;
        }
        $invoice->total_amount=$totalAmount;
        $invoice->save();
        return Response(['code'=>200 , 'message'=>'Thành công','invoice'=>$invoice ],200);
    }

}
