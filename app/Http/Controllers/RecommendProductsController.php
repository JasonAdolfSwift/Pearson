<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\User_evalueation;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

function toProductIntArray($array)
{
    $intArr = array();
    foreach ($array as $item)
    {
        $intArr[] = $item->product_id;
    }

    return $intArr;
}

function toScoreIntArray($array)
{
    $intArr = array();
    foreach ($array as $item)
    {
        $intArr[] = $item[0]->score;
    }

    return $intArr;
}

//传进来两个用户，获取他们两个之间的Pearson相关系数
function getPearsonCorrelationCoefficient($user_a, $user_b)
{
    //////////////////////////////////////////////
    //$user_a->scores = [1,2,3,5,8];
    //$user_a->average = 3.8;
    //
    //$user_b->scores = [0.11,0.12,0.13,0.15,0.18];
    //$user_b->average = 0.138;
    //////////////////////////////////////////////
    $upNum = 0.0;   //公式的分子
    for ($i=0; $i<count($user_a->scores); $i++)
    {
        $upNum += floatval($user_a->scores[$i] - $user_a->average) * floatval($user_b->scores[$i] - $user_b->average);
    }

    $tmp1 = 0.0;
    for ($i=0; $i<count($user_a->scores); $i++)
    {
        $tmp1 += pow(($user_a->scores[$i] - $user_a->average), 2);
    }

    $tmp1 = sqrt($tmp1);

    $tmp2 = 0.0;
    for ($i=0; $i<count($user_b->scores); $i++)
    {
        $tmp2 += pow(($user_b->scores[$i] - $user_b->average), 2);
    }

    $tmp2 = sqrt($tmp2);

    $downNum = $tmp1 * $tmp2; //公式的分母

    if ($downNum == 0)
    {
        return 0;
    }
    return floatval($upNum/$downNum);
}

class RecommendProductsController extends Controller
{
    //
    public function index()
    {
        //首先，获取总共有几个用户评价过商品
        $userIdArr = DB::select('select DISTINCT (user_id) from user_evalueations', []);

        //当前用户评价过的商品
        $objUserProductArr = DB::select('select product_id from user_evalueations WHERE user_id = ?', [$_COOKIE['user_id']]);
        $objUserProductArr = toProductIntArray($objUserProductArr);

        $pearsonArr = array();

        $objUser = new User_info();
        $otherUser = new User_info();

        foreach ($userIdArr as $userId)
        {
            if ($userId->user_id != $_COOKIE['user_id'])
            {
                //另一个用户评价过的商品
                $otherUserProductArr = DB::select('select product_id from user_evalueations WHERE user_id = ?', [$userId->user_id]);
                $otherUserProductArr = toProductIntArray($otherUserProductArr);

                //获得两个用户都评价过的商品id
                $commonProductId = array_intersect($objUserProductArr,$otherUserProductArr);

                //获取当前登陆用户的评分
                $objUser->id = $_COOKIE['user_id'];

                $originalScores = array();
                foreach ($commonProductId as $productId)
                {
                    $originalScores[] = DB::select('select score from user_evalueations WHERE user_id = ? and product_id = ?',
                        [$objUser->id, $productId]);
                }

                $objUser->scores = toScoreIntArray($originalScores);
                $objUser->getAverage();
                $objUser->getStdDeviation();

                //获取对比用户的评分
                $otherUser->id = $userId->user_id;

                $originalScores = array();
                foreach ($commonProductId as $productId)
                {
                    $originalScores[] = DB::select('select score from user_evalueations WHERE user_id = ? and product_id = ?',
                        [$otherUser->id, $productId]);
                }

                $otherUser->scores = toScoreIntArray($originalScores);
                $otherUser->getAverage();
                $otherUser->getStdDeviation();

                $pearsonArr[$userId->user_id] = getPearsonCorrelationCoefficient($objUser, $otherUser);
            }
        }

        arsort($pearsonArr);

        $similarUsr = array_keys($pearsonArr);

        //至此，已经找出最相似的用户
        $similarUsr = $similarUsr[0];

        if ($pearsonArr[$similarUsr] <= 0)
        {
            $resData['status'] = "success";
            $resData['data'] = Product::where('id', "<", 1)->get();
            return $resData;
        }

        $objUserProductArr = DB::select('select product_id from user_evalueations WHERE user_id = ?', [$_COOKIE['user_id']]);
        $objUserProductArr = toProductIntArray($objUserProductArr);

        $otherUserProductArr = DB::select('select product_id from user_evalueations WHERE user_id = ?', [$similarUsr]);
        $otherUserProductArr = toProductIntArray($otherUserProductArr);

        $commonProductId = array_intersect($objUserProductArr,$otherUserProductArr);

        $preRecommendProducts = DB::table('user_evalueations')->where('user_id', '=', $similarUsr)->whereNotIn('product_id', $commonProductId)->get();

        if (count($preRecommendProducts) == 0)
        {
            $resData['status'] = "success";
            $resData['data'] = Product::where('id', "<", 1)->get();
            return $resData;
        }

        $simAtoB = $pearsonArr[$similarUsr];

        $averageUserA = DB::select('select average_rate from users WHERE id = ?', [$objUser->id]);
        $averageUserB = DB::select('select average_rate from users WHERE id = ?', [$similarUsr]);

        $preScoreArr = array();
        foreach ($preRecommendProducts as $preRecommendProduct) {
            $rateOfProduct = DB::select('select score from user_evalueations WHERE user_id = ? and product_id = ?',
                [$similarUsr, $preRecommendProduct->product_id] );

            $preScoreArr[$preRecommendProduct->product_id] = $averageUserA[0]->average_rate + $rateOfProduct[0]->score - $averageUserB[0]->average_rate;
        }

        arsort($preScoreArr);

        $recommendProductId = array_keys($preScoreArr);

        $recommendProductId = $recommendProductId[0];

        $recommendProduct = Product::where('id', '=', $recommendProductId)->first();

        $data = [];

        $resData['status'] = "success";
        $resData['data'] = $recommendProduct;
        return $resData;
    }
}

class User_info
{
    public $id;
    public $average;
    public $std_deviation;
    public $scores;

    public function getAverage()
    {
        $count = count($this->scores);
        $num = 0;
        for ($i=0; $i<$count; $i++)
        {
            $num += $this->scores[$i];
        }
        if($count == 0){
            $this->average = 0;
        } else {
            $this->average = $num / $count;
        }
    }

    public function getStdDeviation()
    {
        $count = count($this->scores);

        if ($count <= 1)
        {
            return false;
        }
        else
        {
            $total_var = 0;
            foreach ($this->scores as $lv)
                $total_var += pow(($lv - $this->average), 2);
            $this->std_deviation = sqrt($total_var / $count);
        }

        return true;
    }
}