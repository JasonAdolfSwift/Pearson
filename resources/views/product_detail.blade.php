@extends('head')
@section('content')
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
        <small>
            {{$product->detail}}
        </small>
    </div>
    <hr>
    <form name="evaluation" action="/evaluation/{{$product->id}}/{{$user_id}}" method="post">
        您对该商品的评价为：
        <select name="value">
            <option value="-1">不喜欢</option>
            <option value="0">没感觉</option>
            <option value="1">还不错</option>
            <option value="2">感兴趣</option>
            <option value="3">很热爱</option>
        </select>
        <input type="submit" value="确认评价">
    </form>
@stop
<br/>
<hr>
<br>