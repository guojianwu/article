/**
 * Created by admin on 2018/3/30.
 */

$(function () {
    $.get('/article/php/token.php').done(function (res) {
        var res=JSON.parse(res);
        // console.log(res);
        var tpl='';
        if(res.err==1 && res.userInfo.username){
           tpl+='<li><a href="javascript:void(0);" class="nav_username">'+res.userInfo.username+'</a></li> <li class="person_center"><a href="/article/view/person_center.html?user_id='+res.userInfo.user_id+'">个人中心</a></li><li class="exit"><a href="javascript:void(0);">退出</a></li>';
        }else {
            tpl+='<li><a class="login" href="/article/view/login.html">登录</a></li> <li><a class="register" href="/article/view/register.html">注册</a></li>';
        }
        $('.navbar-right').html(tpl);

    })
   
    


})