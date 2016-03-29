<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Requests;

class ShowProductsController extends Controller
{
    //
    public function index()
    {
        $data = [];
        $data['products'] = Product::where('id', '<', 100)->take(100)->get();
        $data['user_name'] = $_COOKIE['user_name'];
        return view("show_products", $data);
    }
}
