this.Ajax = (function() {
    function Ajax() {};
    Ajax.get = function(url) {
        var promise = $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json'
        });
        promise.done(function(resData) {
            if (resData.result == 'fail') {
                $.iGrowl({
                    type: 'error',
                    message: resData.msg
                });
                return;
            }
        });
        promise.fail(function() {
            $.iGrowl({
                type: 'error',
                message: '服务器出错！'
            });
        });
        return promise;
    };

    Ajax.post = function(url, postData) {
        var promise = $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: postData
        });
        promise.done(function(resData) {
            if (resData.result == 'fail') {
                $.iGrowl({
                    type: 'error',
                    message: JSON.stringify(resData.msg),delay:0
                });
                return;
            }
        });
        promise.fail(function() {
            $.iGrowl({
                type: 'error',
                message: '服务器出错！'
            });
        });
        return promise;
    };
    Ajax.postFormData = function(url, postData) {
        var promise = $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: postData,
            processData: false,
            contentType: false,
        });
        promise.done(function(resData) {
            if (resData.result == 'fail') {
                $.iGrowl({
                    type: 'error',
                    message: resData.msg
                });
                return;
            }
        });
        promise.fail(function() {
            $.iGrowl({
                type: 'error',
                message: '服务器出错！'
            });
        });
        return promise;
    };


    return Ajax;

})();