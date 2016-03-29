@extends('head')
@section('content')
    <h2 align="center">评价成功，正在跳转...</h2>

    <span id="jump">
        <script language='javascript'>document.location = '/product/{{$product_id}}'</script>
    </span>

    <script type="text/javascript">
        setTimeout( function() {
            document.getElementById('jump').style.display='';
        }, 3000)
    </script>
@stop