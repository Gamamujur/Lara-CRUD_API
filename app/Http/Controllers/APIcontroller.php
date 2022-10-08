<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class APIcontroller extends Controller
{
    public function createProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'price' => 'required|numeric',
            'desc' => 'required|max:100'
        ]);

        if ($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        Product::create([
            'product_name' =>$request->product_name,
            'price' =>$request->price,
            'desc' =>$request->desc,
        ]);

        return response()->json([
            'message' => 'Create data success'
        ]);
    }

    public function getdata(Product $product){
        return response()->json([
            'products' => $product->all()
        ]);
    }

    public function searchdata(Request $request){
        $data = Product::where('product_name','LIKE','%'.$request->product_name.'%')->get();

        return response()->json([
            'datasearch' => $data
        ]);
    }

    public function updatedata(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'price' => 'required|numeric',
            'desc' => 'required|max:100'
        ]);

        if ($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        Product::findOrFail($id)->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'desc' => $request->desc,
        ]);

        return response()->json([
            'DataUpdate' => 'Update data success'
        ]);
    }

    public function deletedata($id){
        $data = Product::findOrFail($id);

        $data->delete();

        return response()->json([
            'Delete_data' => 'Delete data success'
        ]);
    }

}
