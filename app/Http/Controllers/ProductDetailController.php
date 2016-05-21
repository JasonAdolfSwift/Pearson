<?php

namespace App\Http\Controllers;

use App\User_evalueation;
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
        $data['username'] = $_COOKIE["user_name"];
        $query = User_evalueation::query();

        $record = $query->where("user_id", "=", $_COOKIE['user_id'])->where("product_id", "=", $id)->get();

        $data['evaluation'] = $record->get(0)['score'];

        return view('product_detail', $data);
    }
}
