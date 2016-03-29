<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Requests;


class ProductDetailController extends Controller
{
    //
    public function show($id)
    {
        $data = [];
        $product =  Product::where("id", "=", $id)->first();
        $data['product'] = $product;
        $data['user_id'] = $_COOKIE["user_id"];
        return view('product_detail', $data);
    }
}
