<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class MakeProductsController extends Controller
{
    //
    public function make(){

        for($i=1; $i<1001; $i++) {
            $url = "http://photos.pearson.com/$i.jpg";

            $product = new Product();
            $product->id = $i;
            $product->name = "Book" + $i;
            $product->photo_path = $url;
            $product->detail = "Book$i :This is a good book, this book is willing to sale";

            $product->save();
        }
    }

    public function makeUser(){
        for ($i=1; $i<=200; $i++){
            $user = User::find($i);

            $user->name = "user$i";
            $user->password = "123";
            $user->email = "user$i@163.com";
            $user->created_at = Carbon::now();
            $user->updated_at = Carbon::now();

            $user->save();
        }
    }
}
