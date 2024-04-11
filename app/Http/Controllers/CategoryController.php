<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryEditRequest;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(): View {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view ('pages.category.index',['categories'=>$categories]);
    }

    public function store(CategoryRequest $request): Response {
        DB::beginTransaction();
        try {
            $category = new Category();
            $category->uuid = uniqid();
            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            if($request->parentID) {
                $parent = Category::where('uuid',$request->parentID)->first();
                $category->parent_id =$parent->id;
            }
            if ($category->parent_id) {
                $parentCategory = Category::findOrFail($category->parent_id);
                $category->lft = $parentCategory->rgt;
                $category->rgt = $parentCategory->rgt + 1;
                Category::where('rgt', '>=', $parentCategory->rgt)
                    ->increment('rgt', 2);
                Category::where('lft', '>', $parentCategory->rgt)
                    ->increment('lft', 2);
            } else {
                $maxRgt = Category::max('rgt');
                $category->lft = $maxRgt + 1;
                $category->rgt = $maxRgt + 2;
            }

            $category->save();

            DB::commit();

            $category->parent = $category->parent;
            $category->action = $category->action;
            return Response(['code'=>200 , 'message'=>'Tạo mới thành công', 'category'=>$category ],200);

        } catch (\Exception $e) {
            DB::rollback();
            return Response(['code'=>400 , 'message'=>'error msg', 'error'=>$e->getMessage() ],400);
        }

    }

    public function edit(CategoryEditRequest $request, $catUUID): Response {
        $category = Category::where('uuid',$catUUID)->first();
        if($request->parentIDEdit) {
            $parent = Category::where('uuid',$request->parentIDEdit)->first();
            $category->parent_id =$parent->id;
        }else {
            $category->parent_id =NULL;
        }
        $category->name = $request->input('nameEdit');
        $category->slug = $request->input('slugEdit');
        $category->save();
        return Response(['code'=>200 , 'message'=>'Cập nhật thành công', 'category'=>$category ],200);

    }

    public function softDelete(Request $request, $catUUID): Response {
        $record = Category::where('uuid',$catUUID)->first();
        $record->delete();
        return Response(['code'=>200 , 'message'=>'Xóa thành công' ],200);
    }

}
