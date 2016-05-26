@extends('head')
@section('content')
    <body>
        <h2 align="center">最受欢迎图书</h2>
        <hr/>
        <div style="width:90%; margin: 5px 500px">
            @foreach($popular as $product)
                    <a href="/product/{{$product->id}}">
                        <img style="width:30%;height:300px;display: inline-block;margin:5px 5px;" src="{{$product->photo_path}}">
                    </a>
                    <div style="width:30%; text-align:center; font-size: 15px;font-weight: 600">
                        {{$product->name}}
                    </div>
                <hr/>
            @endforeach
        </div>
    </body>
@stop