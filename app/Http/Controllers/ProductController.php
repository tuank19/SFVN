<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Models\Category;
use App\Classes\Utils;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductEditRequest;

class ProductController extends Controller
{
    public function index(): View {
        $products = Product::all();
        return view('pages.product.index',['products'=>$products]);
    }

    public function create(): View {
        $products = Product::all();
        $categories = Category::all();
        $form = Utils::rederAttrForm();
        return view('pages.product.create',['products'=>$products,'categories'=>$categories, 'form'=>$form]);
    }

    public function submitCreate(ProductRequest $request): Response {
        $category = Category::where('uuid', $request->category)->first();
        if(!$category) {
            return Response(['code'=>400 , 'message'=>'Danh mục không tồn tại' ],400);
        }
        $product = new Product;
        $product->category_id=$category->id;
        $product->uuid = uniqid();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();
        $attrs = Attribute::all();
        foreach ($attrs as $attr) {
           if($request[$attr->slug]){
            $pAttr = new ProductAttribute;
            $pAttr->product_id = $product->id;
            $pAttr->attr_slug = $attr->slug;
            $pAttr->attr_value = $request[$attr->slug];
            $pAttr->save();
           }
        }
        return Response(['code'=>200 , 'message'=>'Tạo mới thành công' ],200);
    }

    public function edit($uuid): View {
        $product = Product::where('uuid', $uuid)->first();
        $categories = Category::all();
        $form = Utils::rederAttrFormEdit($product->id);
        return view('pages.product.edit',['product'=>$product,'categories'=>$categories,  'form'=>$form]);
    }

    public function submitEdit(ProductEditRequest $request, $uuid): Response {
        $product = Product::where('uuid', $uuid)->first();
        $category = Category::where('uuid', $request->category)->first();
        if(!$category) {
            return Response(['code'=>400 , 'message'=>'Danh mục không tồn tại' ],400);
        }
        $product->category_id=$category->id;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();
        $attrs = Attribute::all();
        foreach ($attrs as $attr) {
            $pAttr = ProductAttribute::where('product_id',$product->id)->where('attr_slug',$attr->slug)->first();
           if($pAttr && $request[$attr->slug]){
                $pAttr->attr_value = $request[$attr->slug];
                $pAttr->save();
           }else {
                $pAttr = new ProductAttribute;
                $pAttr->product_id = $product->id;
                $pAttr->attr_slug = $attr->slug;
                $pAttr->attr_value = $request[$attr->slug];
                $pAttr->save();
           }
        }
        return Response(['code'=>200 , 'message'=>'Tạo mới thành công' ],200);
    }

    public function softDelete(Request $request, $uuid): Response {
        $record = Product::where('uuid',$uuid)->first();
        $record->delete();
        return Response(['code'=>200 , 'message'=>'Xóa thành công' ],200);
    }

    public function getProduct($catUUID): Response {
        $cat = Category::where('uuid',$catUUID)->first();
        $products = Product::where('category_id',$cat->id)->with('category')->get();
        foreach ($products as $product) {
            $attrUnit = ProductAttribute::where('attr_slug','unit')->where('product_id', $product->id)->first();
            $product->unit = $attrUnit;
        }
        return Response(['code'=>200 , 'message'=>'Xóa thành công', 'products'=>$products ],200);
    }
}
