@extends('head')
@section('content')
    <h1 align="center">Pearson</h1>
    <form align="center" name='login' method='POST' action='/login' onsubmit='check()'>
        邮箱: <input name='email' value=""><br>
        密码: <input name='Pword' value=""><br>
        <input type='submit' value='登录'>

        <script>
            function check(){
                if(myform.Uname.value== "")
                    alert('请输入用户名')
                else if (myform.Pword.value=="")
                    alert('请输入密码')
            }
        </script>
    </form>
    <form align="center" name="register" method="GET" action="/register">
        <input type='submit' value="注册">
    </form>
@stop