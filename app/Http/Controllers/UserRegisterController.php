<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserRegisterController extends Controller
{
    public function index()
    {

        return view('register');
    }

    public function create()
    {
        //根据前端页面传递来的表单来处理数据
        $user=new User;
        $user->name = $_POST['Uname'];
        $user->email = $_POST['email'];
        $user->password = $_POST['Pword'];
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();

        if ($user->save() == true)
        {
            return view('register_success');
        }
        else
        {
            return "Register Failed";
        }
    }
}
