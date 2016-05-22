this.ProductAll = (function () {
    /*
     * 构造函数
     */
    function ProductAll() {
        this.init();
    }
    var S = ProductAll;
    var P = ProductAll.prototype;
    P.init = function () {
        this.initIndex();
        this.initShowAll();
    }
    P.initIndex= function () {
        S.freshIndex();
    };
    P.initShowAll = function () {
        $('.show-all').change(function () {         /*判断是否为查询后的加载页面*/
            if ($(this).prop('checked')) {
                S.getAll({showAllFlag:'true'});
                $('#pagination').hide();
            } else {
                S.getAll({pageNumber:1,showAllFlag:'false'});
                $('#pagination').show();
            }
        })
    }
    S.freshIndex=function(){
        $.get('/recommend_products',{},function(data){
            if(data.status=='success'){
                var html = $('#showModel').html();
                var doTtet = doT.template(html);
                $("#recommend").html(doTtet(data.data));
                S.slider();
            }else{
                alert('系统错误')
            }

        },'json')
        S.getAll({pageNumber:1,showAllFlag:'false'})

    }
    S.getAll=function(params){
         if ($(this).prop('checked') ){
             $.get('/showProductsPage',params,function(data){
                 if(data.status=='success'){
                     var html = $('#allModel').html();
                     var doTtet = doT.template(html);
                     $("#showAll").html(doTtet(data.products));
                 }else{
                     alert('系统错误')
                 }

             },'json')

        }else{
             $.get('/showProductsPage',params,function(data){
                 if(data.status=='success'){
                     var html = $('#allModel').html();
                     var doTtet = doT.template(html);
                     $("#showAll").html(doTtet(data.products));
                     $("#pagination").pagination({
                         items: data.prodectsCount,
                         itemsOnPage:data.pageSize,
                         prevText: "<",
                         nextText: ">",
                         onPageClick: S.pageChange });
                 }else{
                     alert('系统错误')
                 }

             },'json')
         }
    }
    S.pageChange=function(pageNumber){

        $.get('/showProductsPage',{pageNumber:pageNumber,showAllFlag:false},function(data){
            if(data.status=='success'){
                var html = $('#allModel').html();
                var doTtet = doT.template(html);
                $("#showAll").html(doTtet(data.products));
            }else{
                alert('系统错误')
            }

        },'json')
    }
    S.slider=function(){
        $('#demo3').slideBox({

            duration : 1,//滚动持续时间，单位：秒

            easing : 'linear',//swing,linear//滚动特效

            delay : 3,//滚动延迟时间，单位：秒

            hideClickBar : true,//不自动隐藏点选按键

            clickBarRadius : 10

        });
    }
    return ProductAll;
})()