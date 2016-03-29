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
        $user = User::where("email", "=",$_POST['email'])->first();

        if ( !is_null($user) )
        {
            if ($user->password == $_POST['Pword'])
            {
                setcookie("user_id", $user->id, 0, "/");
                setcookie("user_name", $user->name, 0, "/");
                $_COOKIE['user_id'] = $user->id;
                $_COOKIE['user_name'] = $user->name;

                $average = DB::table('user_evalueations')->where('user_id', '=', $user->id)->avg('score');

                DB::update('update users set average_rate = ? WHERE id = ?', [$average, $user->id]);

                return view('products')
                    ->with('user_name', $_COOKIE['user_name'])
                    ->with('user_id', $_COOKIE['user_id']);
            }
            else
            {
                return view('password_error');
            }
        }
        else
        {
            return view('find_no_user');
        }
    }
}
