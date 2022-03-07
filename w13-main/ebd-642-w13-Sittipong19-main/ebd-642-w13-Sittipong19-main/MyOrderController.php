<?php

namespace App\Http\Controllers;

use App\Models\MyOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MyOrderController extends Controller
{
    //
    public function index(){
        $products = Product::with('category')->get();
        $myorder=MyOrder::with('product.category')->get();
        return Inertia::render('MyOrder/Index',['products' => $products,'myorder'=>$myorder]);
    }
    public function store(Request $request){
        // dd($request->all());
        $this->validate($request,[]);
        $product=Product::where('id',$request->input('product_id'))->get();
        foreach($product as $p){
            $price=$p->unit_price;
        }
        $total=$request->amount*$price;
        MyOrder::create([
            'amount'=>$request->amount,
            'product_id'=>$request->input('product_id'),
            'total'=>$total
        ]);
        return redirect()->back();
    }
    public function update(Request $request){

        
        if($request->has('id')){
        $this->validate($request,[]);
        $product=Product::where('id',$request->input('product_id'))->get();
        foreach($product as $p){
            $price=$p->unit_price;
        }
        $total=$request->amount*$price;
            MyOrder::find($request->input('id'))->update([
                'amount'=>$request->amount,
                'product_id'=>$request->input('product_id'),
                'total'=>$total
            ]);
            return redirect()->back();
        }
        
    }
    public function destroy(Request $request){
        MyOrder::find($request->input('id'))->delete();
        return redirect()->back();
    }
}
