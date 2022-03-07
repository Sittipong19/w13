<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index(){
        $products = Product::all();
        $categories = Category::all();
        return Inertia::render('Product/Index',
        ['products' => $products,'categories' => $categories]);
    }
    public function store(Request $request){
        Validator::make($request->all(),[
            'name' => ['required']
        ])->validate();

        Product::create($request->all());

        return redirect()->back()
        ->with('message','Product Created Successfully.');
    }
    public function update(Request $request){
        Validator::make($request->all(),[
            'name' => ['required']
        ])->validate();

        if($request->has('id')){
            Product::find($request->input('id'))->update($request->all());
            return redirect()->back()
            ->with('message','Product Updated Successfully.');
        }
    }
    public function destroy(Request $request){
        Product::find($request->input('id'))->delete();
        return redirect()->back();
    }

}
