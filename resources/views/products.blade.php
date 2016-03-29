@extends('head')
@section('content')
    <p align="right">{{$user_name}}:你好～</p>
    <br/>
    <p align="right">您的ID:{{$user_id}}</p>
    <hr>
    <h2 align="center" id="all">全部商品</h2>
        <script>
            $.ajax({
                url: "/show_products",
                type: "GET",
                dataType:"html",
                success: function (data) {
                    $('#all').after(data);
                },
                error: function (a, b, c) {
                    alert("出错了...请联系开发人员")
                }
            })
        </script>
    <hr/>
    <h2 align="center" id="recommend">为您推荐</h2>
        <script>
            $.ajax({
                url: "/recommend_products",
                type: "GET",
                dataType:"html",
                success: function (data) {
                    $('#recommend').after(data);
                },
                error: function (a, b, c) {
                    alert("出错了...请联系开发人员")
                }
            })
        </script>
@stop