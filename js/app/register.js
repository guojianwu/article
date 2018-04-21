/**
 * Created by admin on 2018/3/29.
 */
$(function () {
    function loginWidth() {
        var clientWidth= document.body.clientWidth;
        if(clientWidth>640){
            $('.reg_form').outerWidth(500);
            $('.reg_form').css({'margin': '2% auto'});
            $('.reg_verifi').css({'top':18})
        }else {
            $('.reg_form').outerWidth('');
            $('.reg_form').css({'margin': '2% 10%'});
            var verifi_width=$('.box_verifi').width()*0.3;
            $('.reg_verifi img').css({'width':verifi_width})
            $('.reg_verifi').css({'top':25})
        }
    }
    loginWidth();
    $(window).resize(function(){
        loginWidth();
    });
    $('.reg_verifi img').on('click',function () {
        var rand=Math.random();
        $(this).attr({'src':'../php/reg_verifi.php?t='+rand});
    })
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
    $('.reg_btn').on('click',function () {
        var username=$.trim($('.username').val());
        var password=$.trim($('.password').val());
        var repassword=$.trim($('.repassword').val());
        var verification=$.trim($('.verification').val());
       
        if(!username || !password || !repassword || !verification ){
            alert_tip('请填写完整信息!!!',1500)
            return false;
        }
        if(password !=repassword){
            alert_tip('两次密码输入不一致',1500)
            return false;
        }

        $.post('/article/php/register.php',{
            username:username,
            password:password,
            repassword:repassword,
            verification:verification
        }).done(function (res) {
            var res=JSON.parse(res);
            if(res.err==1){
                alert_tip('注册成功',1500)
                setTimeout(function () {
                    window.location.href='/article/view/login.html';
                },1000);
            }else if(res.err==-2){
                alert_tip('验证码输入错误',1500)
            }else if(res.err==-3){
                alert_tip('用户名已被注册,请更换',1500)
            }else if(res.err==-2){
                alert_tip('注册失败',1500)
            }
        });





    })

})