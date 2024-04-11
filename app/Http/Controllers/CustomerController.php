<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\Customer;
use Illuminate\Http\Response;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Hash;
use DB;

class CustomerController extends Controller
{
    public function index(): View {
        $customers = Customer::all();
        return view('pages.customer.index',['customers'=>$customers]);
    }

    public function create(CustomerRequest $request): Response {
       $customer = new Customer;
       $customer->uuid = uniqid();
       $customer->name = $request->name;
       $customer->email= $request->email;
       $customer->phone = $request->phone;
       $customer->city_id = $request->city;
       $customer->district = $request->district;
       $customer->ward_id = $request->ward;
       $customer->password = Hash::make(12345678);
       $customer->save();
       $city = DB::table('city')->where('id',$request->city)->first();
       $district = DB::table('district')->where('id',$request->district)->first();
       $ward = DB::table('ward')->where('id',$request->ward)->first();
       return Response(['code'=>200 , 'message'=>'Tạo mới thành công', 'customer'=>$customer, 'city'=>$city, 'district'=>$district, 'ward'=>$ward ],200);
    }

    public function getCustomer($uuid): Response {
        $customer = Customer::where('uuid',$uuid)->first();
        $city = DB::table('city')->where('id',$customer->city_id)->first();
        $district = DB::table('district')->where('id',$customer->district)->first();
        $ward = DB::table('ward')->where('id',$customer->ward_id)->first();
        return Response(['code'=>200 , 'message'=>'Thành công', 'customer'=>$customer, 'city'=>$city, 'district'=>$district, 'ward'=>$ward ],200);
    }

    public function editCustomer($uuid): View {
        $customer = Customer::where('uuid',$uuid)->first();
        $cityCurrent = DB::table('city')->where('id',$customer->city_id)->first();
        $city = DB::table('city')->where('id','!=', $cityCurrent->id)->get();
        $districtCurrent = DB::table('district')->where('id',$customer->district)->first();
        $district = DB::table('district')->where('id','!=', $districtCurrent->id)->get();

        $wardCurrent = DB::table('ward')->where('id',$customer->ward_id)->first();
        $ward = DB::table('ward')->where('id','!=', $wardCurrent->id)->get();
        return view('pages.customer.edit',['customer'=>$customer,
            'cityCurrent'=>$cityCurrent,
            'district'=>$district,
            'ward'=>$ward,
            'city'=>$city,
            'districtCurrent'=>$districtCurrent,
            'wardCurrent'=>$wardCurrent,
        ]);
    }

    public function submitEditCustomer(Request $request, $uuid): Response {
        $customer = Customer::where('uuid',$uuid)->first();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->city_id = $request->city;
        $customer->district = $request->district;
        $customer->ward_id = $request->ward;
        $customer->save();
        return Response(['code'=>200 , 'message'=>'Thành công'],200);
    }

}
