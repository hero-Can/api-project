<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class categoriesController extends Controller
{
    use GeneralTrait;

    public function index(){
       // $categories = Category::get();
       /** select name_ar or name_en depend in request->lang */
        $categories = Category::select('id','name_'.app()->getLocale() .' as name')->get();
        return response()->json($categories);
    }

    public function getCategoryById(Request $request){

        $category = Category::select('id','name_'.app()->getLocale() .' as name')->find($request->id);
        if (!$category) {
           return $this->returnError('001',"category don't exist");
        }
        /** we don't need to do the old style
         *  return response()->json($category);
         * just call the ready method in trait
         */
        return $this->returnData('category',$category);

    }

    public function changeCategoryStatus(Request $request){
        Category::where('id',$request->id)->update(['active'=>$request->active]);
        return $this->returnSuccessMessage("staus of category updated successfully");
    }

    public function getCategoryById2(Request $request,$id){

        $category = Category::select('id','name_'.app()->getLocale() .' as name')->find($id);

       // $category = Category::select('name_'.app()->getLocale() .' as name')->where('id',$request->$id);
        return response()->json($category);
    }
}
