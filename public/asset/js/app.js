/*机房管理*/
this.IdcManage = (function () {
    /*
     * 构造函数
     */
    function IdcManage() {
        this.init();
    }
    var S = IdcManage;
    var P = IdcManage.prototype;
    P.init = function () {
        this.initIndex();
        this.initAction();
    }
    P.initIndex= function () {
        S.freshIndex();
        S.getDeploy();
        S.getDeployLog();
    };
    P.initAction = function (){
        /*全选事件*/
        $(document).on("click",".iChooseAll",function(){
            $("table  td input:checkbox").prop("checked",function(){
                if($(".iChooseAll").prop("checked")==false){
                    return false;
                }
                return true;
            });
        })
        $('[data-toggle="tooltip"]').tooltip();
        /*modal关闭默认事件*/
        $(document).on("hidden.bs.modal",function(){
            $(".waringY").show();
            $(".myClick").removeClass("myClick");
        })
        /*添加机房*/
        $(".addThis").click(function(e){
            e.preventDefault();
            $("#addScript").modal({backdrop:"static",keyboard:false})
        })
        /*删除*/
        $(document).on("click",".deleteThis",function(e){
            $(this).addClass("myClick");
            $(".waringHeadTitle").text("删除");
            $(".waringTitle").text("你确定要删除以下机房吗？");
            $(".waringDetail").html($(this).closest("tr").find('span[name="name"]').text()+"</br>");
            $("#waring").modal({backdrop:"static"});
        })
        /*发布测试*/
        $(document).on("click",".releaseTest",function(e){
            e.preventDefault()
            $(this).addClass("myClick");
            $(".waringHeadTitle").text("发布测试");
            $(".waringTitle").text("你确定要发布测试吗？");
            $(".waringDetail").html("");
            $("#waring").modal({backdrop:"static"});


        })
        /*发布线上*/
        $(document).on("click",".deploy",function(e){
            e.preventDefault()
            $(this).addClass("myClick");
            $(".waringHeadTitle").text("发布线上");
            $(".waringTitle").text("你确定要发布线上吗？");
            $(".waringDetail").html("");
            $("#waring").modal({backdrop:"static"});
        })
        /*发布日志*/
        $(document).on("click",".releaseLog",function(){
            $("#releaseLog").modal({backdrop:"static"});
        })
        /*启用*/
        $("table").on("click",".enable",function(){
            if($(this).data("switchenable")=="1"){
                $(this).addClass("myClick");
                $(".waringHeadTitle").text("启用");
                $(".waringTitle").text("你确定要启用该机房吗？");
                $(".waringDetail").html($(this).closest("tr").find('span[name="name"]').text()+"</br>");
                $("#waring").modal({backdrop:"static"});
            }else{
                $(this).addClass("myClick");
                $(".waringHeadTitle").text("启用");
                $(".waringTitle").text("");
                $(".waringDetail").html($(this).closest("tr").find('span[name="name"]').text()+"是<span style='color:red'>故障机房</span>,请到<a href='/karman/scene' style='color: #3833B7;'>应用场景管理</a>回切。</br>");
                $(".waringY").hide();
                $("#waring").modal({backdrop:"static"});
            }

        })
        /*暂停*/
        $("table").on("click",".disable",function(){
                $(this).addClass("myClick");
                $(".waringHeadTitle").text("暂停");
                $(".waringTitle").text("你确定要暂停该机房吗？");
                $(".waringDetail").html($(this).closest("tr").find('span[name="name"]').text() + "</br>");
                $("#waring").modal({backdrop: "static"});

        })
        /*提示框消失*/
        $(document).on("click","[data-toggle='tooltip']",function(){
            $("#nameTip").tooltip("hide");
        })
        /*保存*/
        $("#addScript").on("click",".add",function(e){
            e.preventDefault();
            var name= $.trim($("#addScript #name").val());
            var remark=$("#addScript #remark").val();
            var count=0;
            if(name==""){
                $("#addScript #nameTip").attr("data-original-title","请输入机房");
                $("#addScript #nameTip").tooltip("show");
                count++;
            }
            if( count==0){
                S.add(name,remark);
            }

        })
        /*修改机房*/
        $(document).on("click",".modifyThis",function(){
            var id=$(this).data("id");
            S.getIdc(id);
        })
        $(document).on("click",".modify",function(e){
            e.preventDefault();
            var id=$(this).data("id");
            var name= $.trim($("#modifyModal #name").val());
            var remark=$("#modifyModal #remark").val();
            var count=0;
            if(name==""){
                $("#modifyModal #nameTip").attr("data-original-title","请输入机房");
                $("#modifyModal #nameTip").tooltip("show");
                count++;
            }
            if( count==0){
                S.modify(id,name,remark);
            }


        })
        $(".waringY").click(function() {
            if ($(".myClick").hasClass("deleteThis")) {
                var id=$(".myClick").data("id");
                $("#waring").modal("hide");
                S.delete(id);
            }
            if ($(".myClick").hasClass("enable")) {
                var id=$(".myClick").data("id");
                var enable=1;
                $("#waring").modal("hide");
                S.ableIdc(id,enable);
            }
            if ($(".myClick").hasClass("disable")) {
                var id=$(".myClick").data("id");
                var enable=0;
                $("#waring").modal("hide");
                S.ableIdc(id,enable);
            }
            if($(".myClick").hasClass("releaseTest")){
                var type=true;
                $("#waring").modal("hide");
                S.getDeploy(type,$(".releaseTest"))
            }
            if($(".myClick").hasClass("deploy")){
                var type=true;
                $("#waring").modal("hide");
                S.getDeploy(type,$(".deploy"))
            }
        })

    }
    S.add=function(name,remark){
        var postData = {name:name,remark:remark};
        var promise = Ajax.post('/karman/api/idc/add', postData);
        promise.then(function (resData) {
            if (resData.result == "success") {
                $("#addScript").modal("hide");
                $.iGrowl({type: 'success', message: '添加成功！'});
                window.location.reload();
            }
        })
    }
    S.ableIdc=function(id,enable){
        var postData = {id:id,enable:enable};
        var promise = Ajax.post('/karman/api/idc/switch', postData);
        promise.then(function (resData) {
            if(resData.result=="success"){
                if(enable==1){
                    $.iGrowl({type: 'success', message: '启用成功！'});
                }else{
                    $.iGrowl({type: 'success', message: '暂停成功！'});
                }

                S.freshIndex();
            }
        })
        promise.always(function(){
            $(".myClick").removeClass("myClick")
        })
    }
    S.delete=function(id){
        var postData = {id:id};
        var promise = Ajax.post('/karman/api/idc/delete', postData);
        promise.then(function (resData) {
            if (resData.result == "success") {
                $("#waring").modal("hide");
                $.iGrowl({type: 'success', message: '删除成功！'});
                S.freshIndex()
            }
        })
        promise.always(function(){
            $(".myClick").removeClass("myClick");
        })


    }
    S.getIdc=function(id){
        var postData = {id:id};
        var promise = Ajax.post('/karman/api/idc/query', postData);
        promise.then(function (resData) {
            if (resData.result == "success") {
                var html = $('#modifyScript').html();
                var doTtet = doT.template(html);
                $('#modifyModal').html(doTtet(resData.data.list));
                $("#modifyModal").modal({backdrop:"static"});
            }
        })
    }
    S.modify=function(id,name,remark){
        var postData = {id:id,name:name,remark:remark};
        var promise = Ajax.post('/karman/api/idc/update', postData);
        promise.then(function (resData) {
            if (resData.result == "success") {
                $("#modifyModal").modal("hide")
                $.iGrowl({type: 'success', message: '修改成功！'});
                S.freshIndex()
            }
        })
        promise.always(function(){
            $(".myClick").removeClass("myClick");
        })
    }
    S.freshIndex=function(){
        var postData = {all: 'y'};
        var promise = Ajax.post('/karman/api/idc/query', postData);
        promise.then(function (resData) {
            if(resData.result=="success"){
                $(".indexAllCount").text(resData.data.allTotal);
                $(".indexAllCount").attr("data-original-title","总共"+resData.data.allTotal+"机房");
                var html = $('#freshScript').html();
                var doTtet = doT.template(html);
                $("#indexBody").html(doTtet(resData.data.list));
                $('[data-toggle="tooltip"]').tooltip();
            }
        })

    }
    S.getDeploy=function(ifDeploy,releaseType){
        var postData ={};
        var promise = Ajax.post('/karman/api/httpdnsdomain/getdeploy', postData);
        promise.then(function (resData) {
            if(resData.result=="success"){
                if(resData.data.canDeployTest){
                    $(".releaseTest").text("发布测试");
                    var type='test';
                    if(ifDeploy && releaseType.hasClass("releaseTest")){
                        S.deploy(type);
                    }
                    $(".releaseTest").attr("disabled",false);
                }else{
                    $(".releaseTest").text(resData.data.list.creator+"在发布测试");
                    $(".releaseTest").attr("disabled",true);
                }
                if(resData.data.canDeployOnline){
                    $(".deploy").text("发布线上");
                    var type='online';
                    if(ifDeploy&& releaseType.hasClass("deploy")){
                        S.deploy(type);
                    }
                    $(".deploy").attr("disabled",false);
                }else if(!resData.data.canDeployOnline && !resData.data.canDeployTest ){
                    $(".deploy").text(resData.data.list.creator+"在发布线上");
                    $(".deploy").attr("disabled",true);
                }else{
                    $(".deploy").text('发布线上');
                    $(".deploy").attr("disabled",true);
                }

            }
        })
        promise.always(function(){
            $(".myClick").removeClass("myClick")
        })
    }
    S.deploy=function(type){
        var postData ={type:type};
        var promise = Ajax.post('/karman/api/httpdnsdomain/deploy', postData);
        promise.then(function (resData) {
            if(resData.result=="success"){
                if(type=='test'){
                    $.iGrowl({type: 'success', message: '发布测试成功'});
                    S.getDeploy();
                }else{
                    $.iGrowl({type: 'success', message: '发布线上成功'});
                    S.getDeploy();
                }
                if(type=="test"){
                    var html = $('#releaseScript').html();
                    var doTtet = doT.template(html);
                    if(typeof(resData.data.list.success)!="undefined"){
                        $("#releaseTestLog #success").html(doTtet(resData.data.list.success));
                    }else{
                        $("#releaseTestLog #success").html("没有数据");
                    }
                    var html1 = $('#releaseScript').html();
                    var doTtet1 = doT.template(html1);
                    if(typeof(resData.data.list.fail)!="undefined"){
                        $("#releaseTestLog #fail").html(doTtet1(resData.data.list.fail));
                    }else{
                        $("#releaseTestLog #fail").html("没有数据");
                    }
                    $("#releaseTestLog").addClass("active");
                    $(".releaseTestTitle").addClass("active");
                    $("#deployLog").removeClass("active");
                    $(".deployTitle").removeClass("active");
                }else{
                    $(".deployTitle").addClass("active");
                    $("#deployLog").addClass("active");
                    $("#releaseTestLog").removeClass("active");
                    $(".releaseTestTitle").removeClass("active");
                    var html = $('#releaseScript').html();
                    var doTtet = doT.template(html);
                    if(typeof(resData.data.list.success)!="undefined"){
                        $("#deployLog #success").html(doTtet(resData.data.list.success));
                    }else{
                        $("#deployLog #success").html("没有数据");
                    }
                    var html1 = $('#releaseScript').html();
                    var doTtet1 = doT.template(html1);
                    if(typeof(resData.data.list.fail)!="undefined"){
                        $("#deployLog #fail").html(doTtet1(resData.data.list.fail));
                    }else{
                        $("#deployLog #fail").html("没有数据");
                    }
                }
            }else{
                if(type=="test"){
                    var html = $('#releaseScript').html();
                    var doTtet = doT.template(html);
                    if(typeof(resData.data.list.success)!="undefined"){
                        $("#releaseTestLog #success").html(doTtet(resData.data.list.success));
                    }else{
                        $("#releaseTestLog #success").html("没有数据");
                    }
                    var html1 = $('#releaseScript').html();
                    var doTtet1 = doT.template(html1);
                    if(typeof(resData.data.list.fail)!="undefined"){
                        $("#releaseTestLog #fail").html(doTtet1(resData.data.list.fail));
                    }else{
                        $("#releaseTestLog #fail").html("没有数据");
                    }
                    $("#releaseTestLog").addClass("active");
                    $(".releaseTestTitle").addClass("active");
                    $("#deployLog").removeClass("active");
                    $(".deployTitle").removeClass("active");
                    setTimeout(function(){
                        $("#releaseLog").modal({backdrop:"static"});
                    },300)
                }else{
                    $(".deployTitle").addClass("active");
                    $("#deployLog").addClass("active");
                    $("#releaseTestLog").removeClass("active");
                    $(".releaseTestTitle").removeClass("active");
                    var html = $('#releaseScript').html();
                    var doTtet = doT.template(html);
                    if(typeof(resData.data.list.success)!="undefined"){
                        $("#deployLog #success").html(doTtet(resData.data.list.success));
                    }else{
                        $("#deployLog #success").html("没有数据");
                    }
                    var html1 = $('#releaseScript').html();
                    var doTtet1 = doT.template(html1);
                    if(typeof(resData.data.list.fail)!="undefined"){
                        $("#deployLog #fail").html(doTtet1(resData.data.list.fail));
                    }else{
                        $("#deployLog #fail").html("没有数据");
                    }
                    setTimeout(function(){
                        $("#releaseLog").modal({backdrop:"static"});
                    },300)
                }
            }
        })
    }
    S.getDeployLog= function () {
        var postData ={all:'y', orderBy:'id', orderType:'desc'};
        var promise = Ajax.post('/karman/api/deploylog/query', postData);
        promise.then(function (resData) {
            if (resData.result == "success") {
                var tet=0;
                var dep=0;
                $.each(resData.data.list,function(i,res){
                    if(res.stage=="test" && tet==0 && res.remark!=""){
                        tet++;
                        var html = $('#releaseScript').html();
                        var doTtet = doT.template(html);
                        if(typeof(JSON.parse(res.remark).success)!="undefined"){
                            $("#releaseTestLog #success").html(doTtet(JSON.parse(res.remark).success));
                        }
                        var html1 = $('#releaseScript').html();
                        var doTtet1 = doT.template(html1);
                        if(typeof(JSON.parse(res.remark).fail)!="undefined"){
                            $("#releaseTestLog #fail").html(doTtet1(JSON.parse(res.remark).fail));
                        }
                    }
                    if(res.stage=='online' && dep==0 && res.remark!=""){
                        dep++;
                        var html = $('#releaseScript').html();
                        var doTtet = doT.template(html);
                        if(typeof(JSON.parse(res.remark).success)!="undefined"){
                            $("#deployLog #success").html(doTtet(JSON.parse(res.remark).success));
                        }
                        var html1 = $('#releaseScript').html();
                        var doTtet1 = doT.template(html1);
                        if(typeof(JSON.parse(res.remark).success)!="undefined"){
                            $("#deployLog #fail").html(doTtet1(JSON.parse(res.remark).fail));
                        }
                    }

                })


            }
        })
    }
    return IdcManage;
})()