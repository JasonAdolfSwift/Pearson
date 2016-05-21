@extends('head')
@section('content')
        <!DOCTYPE html>
    <style>
        .login-img{
            padding:0 50px;
        }
        @media (max-width: 767px){
            .login-img{
                padding:0;
            }
            .login-blur{
                background: none;
            }
        }
        body{
            background: url(http://s17.mogucdn.com/b7/pic/160416/nihao_ifrwgzrwgbqwintgg4zdambqhayde_2560x1600.jpg) no-repeat top center fixed transparent;
            background-size: cover;
        }
        .con-wrapper{
            padding-top:10%;
            margin:0 20px;
        }
        .login-wrapper{
            position:relative;
        }
        .login-form-wrapper{
            margin: 0 auto;
            width: 500px;
            position:relative;
            z-index: 999;
            padding:20px 40px 30px;
            background:rgba(255,255,255,0.6);
            overflow: hidden;
            zoom: 1;
            -webkit-box-shadow: 0 4px 4px rgba(0,0,0,0.3);
            -moz-box-shadow: 0 4px 4px rgba(0,0,0,0.3);
            box-shadow: 0 4px 4px rgba(0,0,0,0.3);
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            -ms-border-radius: 3px;
            -o-border-radius: 3px;
            border-radius: 3px;
        }
        .login-blur{
            position:absolute;
            left:0;
            top:0;
            width:100%;
            height:100%;
            zoom: 1;
            background: url(http://s17.mogucdn.com/b7/pic/160416/nihao_ifrwgzrwgbqwintgg4zdambqhayde_2560x1600.jpg) no-repeat top center fixed transparent;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;

            -webkit-filter: blur(3px);
            -moz-filter: blur(3px);
            -o-filter: blur(3px);
            -ms-filter: blur(3px);
        }
    </style>
<body>
<div class="con-wrapper">
    <div class="center-block w-auto-xs login-wrapper login-width">
        <div class="login-blur"></div>
        <div class="login-form-wrapper">
            <a href class="navbar-brand block m-b login-img">
                <h1 style="color:#f9f9f9 ">Pearson </h1>
                <!-- <img src="/PearSon/public/lib/img/loginTitle.png" style="max-height:100px;width:100%;">-->
            </a>
            <div name="form" class="form-validation">
                <div class="form-group">
                    <input type="text" placeholder="请输入用户名" autofocus id="username" class="form-control no-border">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="请输入密码" id="password" class="form-control no-border">
                </div>
                <button class="btn btn-primary btn-block" id="login">登录</button>
                <div class="text-center m-t font-bold">
                    没有帐号?点击
                    <a href="/register" style="font-size: 14px" class="text-primary font-bold">注册</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    $("#login").click(function(){
        $.post('/login', {username:$("#username").val(),password:$("#password").val()},function(result){
            if(result.status=='success'){
                window.location.href='/products';
            }else{
              alert(result.msg);
            }
        },'json');
    })


</script>
@stop