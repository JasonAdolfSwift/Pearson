<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Requests;

class ShowProductsController extends Controller
{
    //
    public function getProductCount()
    {
        $pageSize = 8;

        $data = [];
        $data['prodectsCount'] = Product::where('id', '>', 1)->count();

        $productsCount = $data['prodectsCount'];

        $pageCount = 1;
        if ($productsCount > $pageSize) {
            $pageCount = intval($productsCount / $pageSize + 1);
        }

        $data['pageCount'] = $pageCount;
        $data['username'] = $_COOKIE['user_name'];
        $data['pageSize'] = $pageSize;
        $data['status'] = "success";
        $data['msg'] = "成功";
        return $data;
    }

    public function queryProductsPage()
    {
        $showAllFlag = $_GET['showAllFlag'];

        $data = [];

        if ($showAllFlag != "true")
        {
            $pageNumber = $_GET['pageNumber'];
            $pageSize = 8;
            $startIdx = ($pageNumber - 1) * $pageSize;

            $data['prodectsCount'] = Product::where('id', '>', 0)->count();

            $productsCount = $data['prodectsCount'];

            $pageCount = 1;
            if ($productsCount > $pageSize) {
                $pageCount = intval($productsCount / $pageSize + 1);
            }

            $data['pageCount'] = $pageCount;

            $data['products'] = Product::where('id', '>', $startIdx)->take($pageSize)->get();
            $data['username'] = $_COOKIE['user_name'];
            $data['pageSize'] = $pageSize;
            $data['status'] = "success";
            $data['msg'] = "成功";

        } else {
            $data['products'] = Product::where('id', '>', 0)->get();
            $data['username'] = $_COOKIE['user_name'];
            $data['status'] = "success";
            $data['msg'] = "成功";
        }


        return $data;
    }

    public function show()
    {
        $username = $_COOKIE['user_name'];

        return view('products')->with('username', $username);
    }
}
