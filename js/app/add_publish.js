$(function () {
    $.get('/article/php/token.php').done(function (res) {
        var res = JSON.parse(res);
        if(res.err!=1){
            window.location.href='/article/view/login.html'
            return false;
        }
    })
})