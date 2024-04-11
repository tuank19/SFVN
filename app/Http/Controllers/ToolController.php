<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use DB;

class ToolController extends Controller
{
    public function cityList(): Response {
        $cities = DB::table('city')->get();
        return Response(['code'=>200 , 'message'=>'Success', 'cities'=>$cities ],200);
    }

    public function districtList($cityID): Response {
        $districts = DB::table('district')->where('city_id', $cityID)->get();
        return Response(['code'=>200 , 'message'=>'Success', 'districts'=>$districts ],200);
    }

    public function wardList($districtID): Response {
        $wardList = DB::table('ward')->where('district_id', $districtID)->get();
        return Response(['code'=>200 , 'message'=>'Success', 'wardList'=>$wardList ],200);
    }
}
