<style>
    .divcss5{ border:1px solid #000; width:300px; height:300px;overflow:hidden}
    .divcss5 img{max-width:300px;_width:expression(this.width > 300 ? "300px" : this.width);}
</style>

<table>
    <tr>
        <td>
            @foreach($products as $product)
                <div class="divcss5" style="float: left">
                    <a href="/product/{{$product->id}}" >
                        <img src={{$product->photo_path}} />
                    </a>
                </div>
                <h3 align="center">
                    {{$product->name}}
                </h3>
            @endforeach
        </td>
    </tr>
</table>

