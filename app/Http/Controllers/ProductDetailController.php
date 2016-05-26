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
        if ($id < 1){
            return view('products')->with('username', $_COOKIE['user_name']);
        }
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

    public function getPopularProduct()
    {
        $this->getAverageScore();

        $products = Product::where("id", ">", 0)->get()->sortBy(function($score) {
            return $score->average_score;
        });

        $idx = 0;
        $top = [];
        foreach ($products as $product) {
            $top[$idx] = $product;
            $idx++;

            if ($idx == 8) {
                break;
            }
        }

        $resData['popular'] = $top;
        return view('popular', $resData);
    }

    public function getAverageScore()
    {
        for ($i=1; $i<=1000; $i++)
        {
            $product = Product::where("id", "=", $i)->first();

            $scores = User_evalueation::where("product_id", "=", $product->id)->get();

            if (count($scores) < 3) {
                continue;
            }

            $count = 0;
            $scoreSum = 0;

            foreach($scores as $score) {
                $count++;
                $scoreSum += $score->score;
            }

            $product->average_score = floatval($scoreSum) / $count;

            $product->save();
        }
    }
}
