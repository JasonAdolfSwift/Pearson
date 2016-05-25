<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

use App\Http\Requests;

class MakeProductsController extends Controller
{
    //
    public function make(){

        $baseUrl = "photos.pearson.com/";
        for($i=1; $i<1001; $i++) {
            $url = "photos.pearson.com/$i.jpg";

            $product = new Product();
            $product->id = $i;
            $product->name = "Book" + $i;
            $product->photo_path = $url;
            $product->detail = "Book$i :This is a good book, this book is willing to sale";

            $product->save();
        }
    }
}
