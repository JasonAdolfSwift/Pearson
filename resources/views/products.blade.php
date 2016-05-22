@extends('head')
@section('content')
    <body>
    <script src="/vendor/slider/slider.min.js"></script>
    <script src="/vendor/simplePagination/jquery.simplePagination.min.js"></script>
    <script src="/asset/js/app.js"></script>
    <header id="header" class="app-header navbar" role="menu">
        <div class="navbar-header bg-blue-dk">
            <a href="" class="navbar-brand text-lt">
                Pearson
            </a>
        </div>
        <div class="collapse pos-rlt navbar-collapse box-shadow bg-blue">
            <a href="#" class="dropdown-toggle pull-right" data-toggle="dropdown" style="margin-top:10px ">
                <img src="/lib/img/1.jpg" data-toggle="tooltip" data-placement="left" title="{{$username}}"  class="avatar" style="width: 40px;height: 20px;display: inline-block">
                <span style="color:white">{{$username}}</span>
                <i class="caret"></i>
            </a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <a href="/" class="signOut"><b>退出</b></a>
                </li>
            </ul>
        </div>
        <script type="text/javascript">
            $(".signOut").click(function(){
                window.close()
            })

        </script>
    </header>
     <h3 align="center"   id="recommend">为您推荐</h3>
      <div id="recommend">
      </div>
    <h3 align="center" >全部商品</h3>
    <div id="showAll" style="width:97%;margin:0 auto">
    </div>
    <nav class="clearfix b-t"      style="border-color: #eaeff0;display: inline-block;width:100%"> 
        <div class="pull-left m-t m-l" style="margin:26px 5px;"> 
            <label class="font-bold m-r text-sm pull-left"                style="margin-top:2px;">全部显示</label> 
            <label class="i-switch bg-success pull-left"> 
                <input type="checkbox" class="show-all">             <i></i>         </label>     </div> 
        <div class="pull-left" style="margin-left:300px;width:600px;"> 
            <ul id="pagination" class="pagination pagination-sm"             style="width:100%;">         </ul> 
        </div> </nav>
    <script type="text/template" id="showModel">
        <div id="demo3" class="slideBox">
            <ul class="items">
                <{~it:value:index}>
                <li>
                    <div class="row">
                        <div style="height: 400px" class="col-xs-4 col-md-12">
                          <a href='/product/<{=value.id}>' class="thumbnail" title="<{=value.name}>"><img src="<{=value.photo_path}>"></a>
                        </div>
                    </div>
                </li>
                <{~}>
             </ul>
         </div>
    </script>
    <script type="text/template" id="allModel">
                <{~it:value:index}>
                    <div style="width:23%;height:250px;display: inline-block;margin:5px 5px">
                            <a href='/product/<{=value.id}>' class="thumbnail" title="<{=value.name}>"><img src="<{=value.photo_path}>"></a>
                            <div style="width:90%; text-align:center; font-size: 15px;font-weight: 600"> <{=value.name}> </div>
                    </div>
                  <{? (index+1) % 4 ==0}>
                    <br/>
                    <{?}>
                <{~}>
    </script>
    <script type="text/javascript">
        var productAll=new ProductAll();
    </script>
    </body>
@stop