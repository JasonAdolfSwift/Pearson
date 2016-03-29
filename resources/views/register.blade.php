@extends('head')
@section('content')
<h1 align="center">注册</h1>
<br/>
<form align="center" name='register' method='POST' action='/register/create' onsubmit='check()'>
    用户名: <input name='Uname' value="请输入用户名"><br>
    密码: <input name='Pword' value="请输入密码"><br>
    确认密码: <input name='CP' value="请重复输入您的密码"><br>
    邮箱: <input name='email' value="请输入您的邮箱"><br>
    <input type='submit' value='提交'>

    <script>
        function check(){
            if(myform.Uname.value== "")
                alert('请输入用户名')
            else if (myform.Pword.value=="")
                alert('请输入密码')
        }
    </script>
</form>
@stop