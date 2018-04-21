require.config({
    paths:{
        "text":'text',
        "jquery":"jquery.min",
        "top":"app/top",
        "public":"app/public"
    },
    shim:{
        "top":['jquery']
    }
});
require(['text!../view/tpl/top.html','jquery'],function (top,jq) {
    document.getElementById('nav').innerHTML=top;
    require(['top','public']);
    var pageType=document.getElementById('require').getAttribute('data-page');
    var pageArr=['index','details','login','register','person_center','add_publish','publish_type','personal'];
   
    for(var i=0;i<pageArr.length;i++){
        if (pageArr[i]==pageType){
            require(['app/'+pageType]);
        }
    }


})