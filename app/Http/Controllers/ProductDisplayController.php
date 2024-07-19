<?php

namespace App\Http\Controllers;


use App\Models\Api\Product;
use Illuminate\Http\Request;

class ProductDisplayController extends Controller
{
    public function index(){
        $products = Product::query()->orderBy('updated_at', 'desc')->paginate(3);
        return view('product.index', [
            'products' => $products
        ]);
    }

    public function view(Product $product){
        return view('product.view', ['product' => $product]);

            }
}
