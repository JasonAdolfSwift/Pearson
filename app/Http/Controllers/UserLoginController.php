<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class UserLoginController extends Controller
{
    //
    public function index()
    {
        $user = User::where("name", "=",$_POST['username'])->first();

        if ( !is_null($user) )
        {
            if ($user->password == $_POST['password'])
            {
                setcookie("user_id", $user->id, 0, "/");
                setcookie("user_name", $user->name, 0, "/");
                $_COOKIE['user_id'] = $user->id;
                $_COOKIE['user_name'] = $user->name;

                $average = DB::table('user_evalueations')->where('user_id', '=', $user->id)->avg('score');

                DB::update('update users set average_rate = ? WHERE id = ?', [$average, $user->id]);

                $resData = [];

                $resData['status'] = "success";
                $resData['url'] = "/getProductCount";
                $resData['username'] = $_COOKIE['user_name'];
                $resData['userId'] = $_COOKIE['user_id'];

                return $resData;
            }
            else
            {
                $resData['status'] = "failed";
                $resData['msg'] = "密码错误";
                return $resData;
            }
        }
        else
        {
            $resData['status'] = "failed";
            $resData['msg'] = "用户不存在";
            return $resData;
        }
    }

    public function verify()
    {
        return view('products')
            ->with('user_name', $_COOKIE['user_name'])
            ->with('user_id', $_COOKIE['user_id']);
    }
}
