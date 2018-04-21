/**
 * Created by admin on 2018/3/29.
 */
$(function () {
    $.get('/article/php/put_publish_types.php').done(function (res) {
        var res=JSON.parse(res);
        var nav_li=$('.mav_top .publish_types');
        var tpl='';
        var types_class_name=['richang','meishi','biancheng','lvyou','qita'];
        for (var i=0;i<res.length;i++){
            tpl+='<li class="type_name click_bg '+types_class_name[i]+'"><a href="/article/view/publish_type.html?pub_type='+res[i].type_name+'">'+res[i].type_name+'</a></li>';
        }
        nav_li.html(tpl);

        var add_publish_type=$('.add_publish_type');
        var tpl='';
        for (var i=0;i<res.length;i++){
           tpl+='<option>'+res[i].type_name+'</option>';

        }
        add_publish_type.html(tpl);

        function urlParam(name, text){
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(text) || new RegExp(name + '=([^&#]*)').exec(text);
            if (results==null){
                return null;
            }else{
                return results[1] || 0;
            }
        }


        var param=decodeURI(urlParam('pub_type',window.location.href));
        if(param){
            var typeClassName;
            switch (param){
                case '日常':
                    typeClassName='.'+types_class_name[0];
                    break;
                case '美食':
                    typeClassName='.'+types_class_name[1];
                    break;
                case '编程':
                    typeClassName='.'+types_class_name[2];
                    break;
                case '旅游':
                    typeClassName='.'+types_class_name[3];
                    break;
                case '其他':
                    typeClassName='.'+types_class_name[4];
                    break;
            }
            $(typeClassName).css({'background':'#ccc'});
        }

        if(window.location.href.indexOf('index.html')>-1){
            $('.index').css({'background':'#ccc'});
        }
        if(window.location.href.indexOf('person_center.html')>-1){
            $('.person_center').css({'background':'#ccc'});
        }
        if(window.location.href.indexOf('login.html')>-1){
            $('.login').css({'background':'#ccc'});
        }
        if(window.location.href.indexOf('register.html')>-1){
            $('.register').css({'background':'#ccc'});
        }












    })

    $('body').on('click','.exit',function () {
        $.post('/article/php/exit.php',{
            exit:'exit'
        }).done(function (res) {
            var res=JSON.parse(res);
            if(res.err==1){
                setTimeout(function () {
                    window.location.href='/article/view/index.html';
                },500);
            }
        })
    })


})