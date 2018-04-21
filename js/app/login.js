/**
 * Created by admin on 2018/3/29.
 */

$(function () {
    function loginWidth() {
        var clientWidth= document.body.clientWidth;
        if(clientWidth>640){
            $('.login_form').outerWidth(500);
            $('.login_form').css({'margin': '2% auto'});
            $('.login_verifi').css({'top':18})
        }else {
            $('.login_form').outerWidth('');
            $('.login_form').css({'margin': '2% 10%'});
            var verifi_width=$('.box_verifi').width()*0.3;
            $('.login_verifi img').css({'width':verifi_width})
            $('.login_verifi').css({'top':25});
        }
    }
    loginWidth();
    $(window).resize(function(){
        loginWidth();
    });
    $('.login_verifi img').on('click',function () {
        var rand=Math.random();
        $(this).attr({'src':'../php/login_verifi.php?t='+rand});
    });

    $('.login_btn').on('click',function () {
        var username=$.trim($('.username').val());
        var password=$.trim($('.password').val());
        var verification=$.trim($('.verification').val());
        var remember=$('.remember').is(':checked');
        remember=remember?1:0;
        if(!username || !password || !verification ){
            alert_tip('请填写完整信息',1500);
            return false;
        }
        $.post('/article/php/login.php',{
            username:username,
            password:password,
            verification:verification,
            remember:remember
        }).done(function (res) {
            var res=JSON.parse(res);
            if(res.err==1){
                alert_tip('登陆成功',1500)
                setTimeout(function () {
                    window.location.href='/article/view/person_center.html?user_id='+res['user_id'];
                },1000);
            }else if(res.err==-1){
                alert_tip('验证码错误',1500)
            }else if(res.err==-2){
                alert_tip('登陆失败',1500)
            }else if(res.err==-3){
                alert_tip('该用户名还没注册',1500)
            }else if(res.err==-4){
                alert_tip('密码或用户名错误',1500)
            }
        })
    });


    function alert_tip(text,time) {
        $('.box_alert > div').text(text);
        $('.box_alert').show();
        $('.box_alert').stop().animate({'top':'7%'},200);
        setTimeout(function () {
            $('.box_alert').fadeOut(500,function () {
                $('.box_alert').css({'top':'5%'})
            });

        },time);
    }



})