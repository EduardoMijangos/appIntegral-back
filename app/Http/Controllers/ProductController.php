<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
/*     public function newProduct(Request $request ) {
        $product = product::create($request->all());
        return response($product, 200);
    } */

    public function getProductos(){
        return response()->json(product::all(), 200);
    }

    public function newProduct(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'price'=> 'required',
            'price_sale'=> 'required',
            'stock' => 'required | numeric ',
            'expired' => 'required',
            'category_id' => 'required',
            'code' => 'required',
            'image' => 'required|image|max:2048',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $rutaArchivoImg = $request->file('image')->store('public/imgproductos');
        $producto = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'price_sale' => $request->price_sale,
            'image' => $request->rutaArchivoImg,
            'stock' => $request->stock,
            'code' => $request->code,
            'expired' => $request->expired,

        ]);

        return response()->json(['producto' => $producto], 201);
    }
}
