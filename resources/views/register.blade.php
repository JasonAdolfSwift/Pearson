@extends('head')
@section('content')
<br/>
<body>
<div class="app app-header-fixed  app-aside-fixed">
    <header id="header" class="app-header navbar bg-black">
        <div class="container-fluid">
            <div class="navbar-header" style="width:300px;">
                <a class="navbar-brand text-lt" href="/">
                    Person
                </a>
                    <span class="text-md" style="color:#fff;">
                        <i class="fa fa-ellipsis-v m-r-md"></i>注册
                    </span>
            </div>
        </div>
    </header>
    <div id="content" class="app-content" role="main">
        <div class="app-content-body">
            <div class="wrapper-lg m-t-lg">
                <div class="form-horizontal" name="form">
                    <div class="form-group first-step">
                        <label class="col-sm-3 control-label">
                            用户名
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="请输入用户名" ng-model="ctrl.domain" id="username" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            密码
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" placeholder="请输入密码" ng-model="ctrl.phone" id="password" required />
                        </div>
                    </div>
                    <div class="form-group third-step ">
                        <label class="col-sm-3 control-label">
                            确认密码
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-4">
                            <input type="password" id="confirmPwd" class="form-control" placeholder="请再次输入密码" required />
                        </div>
                    </div>
                    <div class="form-group third-step ">
                        <label class="col-sm-3 control-label">
                            邮箱
                        </label>
                        <div class="col-sm-4">
                            <input type="email" id="email" class="form-control" placeholder="请输入邮箱" required />
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-sm-offset-3 col-sm-4">
                            <a class="btn btn-success w-xs" id="subBtn">提交</a>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('onblur','#confirmPwd',function(){
        console.log($.trim($("#confirmPwd").val())+'==='+$.trim($("#password").val()))
        if($.trim($("#confirmPwd").val())!= $.trim($("#password").val())){
            alert('密码不一致')
        }
    })
    $("#subBtn").click(function(){
        var username= $.trim($("#username").val());
        var password= $.trim($("#password").val());
        var confirmPwd=$.trim($("#confirmPwd").val());
        var email= $.trim($("#email").val());
        $.post('/register/create', {username:username,password:password,email:email},function(result){
            if(result.status=='success'){
                window.location.href=result.url;
            }else{
                alert(result.msg);
            }
        },'json');
    })
    var product=new Product();
</script>
</body>
</html>
@stop