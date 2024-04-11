<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Classes\Utils;
use App\Models\Attribute;
use App\Http\Requests\AttributeRequest;

class AttributeController extends Controller
{
    public function index(): View {
        $attrs = Attribute::all();
        return view('pages.attribute.index',['attrs'=>$attrs]);
    }

    public function create(AttributeRequest $request): Response {
        $attr = new Attribute;
        $slug = Str::slug($request->name);
        $attr->uuid = uniqid();
        $attr->name = $request->name;
        $attr->slug = $slug;
        $attr->input_type = $request->inputType;
        if($request->selectOption) {
            $jsonSelectOption = [];
            foreach ($request->selectOption as $value) {
                $jsonSelectOption[$value] = $value;
            }
            $jsonSelectOption = json_encode($jsonSelectOption);

            $attr->input_option = $jsonSelectOption;
        }
        $attr->status = 1;

        $attr->save();
        return Response(['code'=>200 , 'message'=>'Tạo mới thành công', 'attr'=>$attr ],200);
    }

    public function edit(Request $request, $uuid): View {
        dd($request->all());
        return view('pages.attribute.edit');
    }
}
