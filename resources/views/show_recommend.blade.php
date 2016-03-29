<style>
    .divcss5{ border:1px solid #000; width:300px; height:300px;overflow:hidden}
    .divcss5 img{max-width:300px;_width:expression(this.width > 300 ? "300px" : this.width);}
</style>

<table>
    <tr>
        <td>
            <div class="divcss5" style="float: left">
                <a href="/product/{{$recommendProduct->id}}" >
                    <img src={{$recommendProduct->photo_path}} />
                </a>
            </div>
            <h3 align="center">
                {{$recommendProduct->name}}
            </h3>
        </td>
    </tr>
</table>