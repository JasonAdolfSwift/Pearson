<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User_evalueation;
use App\Http\Requests;

class UserEvaluationController extends Controller
{
    //
    public function index($product_id, $user_id)
    {
        $record = User_evalueation::whereRaw('user_id = ? and product_id = ?', [$user_id, $product_id])->first();

        if ( is_null($record) )
        {
            $record = new User_evalueation;
            $record->user_id = $user_id;
            $record->product_id = $product_id;
            $record->score = $_POST['value'];

            if ($record->save() != true)
            {
                return "评价失败，请联系开发人员!";
            }
        }
        else
        {
            $record->score = $_POST['value'];
            if ($record->save() != true)
            {
                return "评价失败，请联系开发人员!";
            }
        }

        return view('evaluate_success')
            ->with('product_id', $product_id)
            ->with('user_id', $user_id);
    }
}
