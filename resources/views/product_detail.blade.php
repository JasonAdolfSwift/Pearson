@extends('head')
@section('content')
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
    <h2 align="center">{{$product->name}}</h2>

    <style>
        .divcss5{ border:1px solid #000; width:300px; height:300px;overflow:hidden}
        .divcss5 img{max-width:300px;_width:expression(this.width > 300 ? "300px" : this.width);}
    </style>

    <div align="center">
        <img src={{$product->photo_path}} />
    </div>

    <hr>
    <div>
        <h3 align="center">商品描述</h3>
        <div class="col-sm-12" > 
            <textarea class="form-control" rows="24">
                {{$product->detail}}
            </textarea> 
        </div> 
    </div>
    <hr>
    <form name="evaluation" class="form-horizontal" action="/evaluation/{{$product->id}}/{{$user_id}}" method="post">
        <div class="form-group"> 
          <label class="col-sm-2 control-label" style="font-size: 15px;font-weight: 600">您对该商品的评价为：</label>
         <select class="form-control" style="width: 100px;display: inline-block" name="values">
             <option value="1" @if ($evaluation==1) selected @endif>1分</option>
             <option value="2" @if ($evaluation==2) selected @endif>2分</option>
             <option value="3" @if ($evaluation==3) selected @endif>3分</option>
             <option value="4" @if ($evaluation==4) selected @endif>4分</option>
             <option value="5" @if ($evaluation==5) selected @endif>5分</option>
             <option value="6" @if ($evaluation==6) selected @endif>6分</option>
             <option value="7" @if ($evaluation==7) selected @endif>7分</option>
             <option value="8" @if ($evaluation==8) selected @endif>8分</option>
             <option value="9" @if ($evaluation==9) selected @endif>9分</option>
             <option value="10" @if ($evaluation==10) selected @endif>10分</option>
         </select>
            &nbsp;&nbsp;
          <button class="btn btn-info " type="submit">确认评价</button>
            &nbsp;&nbsp;
            <a class="btn btn-primary" href="/products" >返回</a>
            </div>
    </form>
@stop