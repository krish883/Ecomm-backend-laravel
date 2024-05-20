<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //

    function addProduct(Request $req){
        $product=new Product;
        $product->name=$req->input('name');
        $product->price=$req->input('price');
        $product->description=$req->input('description');
        $product->file_path=$req->file('file')->store('products');
        $product->save();
        return $product;
    }

    function list(){
        return Product::all();
         
    }

    function delete($id){
       
        $result = Product::where('id',$id)->delete();
        if($result)
        {
             return ["result"=>"product has been delete"];
        }
        else{
            return ["result"=>"Operation failed"];
        }
    }


    function getProduct($id){
          return Product::find($id);
    }



    function updateProduct(Request $req, $id){
        $product = Product::find($id);
    if(!$product){
        return response()->json(['message' => 'Product not found'], 404);
    }

    $product->name = $req->input('name');
    $product->price = $req->input('price');
    $product->description = $req->input('description');

    if($req->hasFile('file')){
        if($product->file_path){
            Storage::delete($product->file_path);
        }
        // Store the new file
        $product->file_path = $req->file('file')->store('products');
    }

    $product->save();
    return $product;
  }
}
