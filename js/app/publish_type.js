/**
 * Created by admin on 2018/3/29.
 */
new Vue({
    el:"#app",
    data:{
        PublishDate:[],
        publishCount:0
    },
    mounted: function () {
        this.$nextTick(function () {
            this.getPublishDate();
        })
    },
    methods:{
        getPublishDate:function (currentpage,pagesize) {
            var currentpage=currentpage?currentpage:1;
            var pagesize=pagesize?pagesize:10;
            var param=this.urlParam("pub_type", window.location.href);
            param=decodeURI(param);
            document.getElementsByTagName('title')[0].innerHTML=param;
            var self=this;
            axios.get('/article/php/put_publish.php?pub_type='+param+'&currentpage='+currentpage+'&pagesize='+pagesize)
                .then(function (response) {
                    self.PublishDate=response.data;
                    self.publishCount=parseInt(response.data.count);
                    self.sub_pub_content();
                })


        },
        currentChange:function (num) {
            this.getPublishDate(num,10);
            window.scrollTo(0,0);
        },
        sub_pub_content:function () {
            for (var i=0;i<this.PublishDate.publish.length;i++){
                this.PublishDate.publish[i]['pub_content']=this.PublishDate.publish[i]['pub_content'].substring(0,1200);
            }
        },
        urlParam:function (name, text){
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(text) || new RegExp(name + '=([^&#]*)').exec(text);
            if (results==null){
                return null;
            }else{
                return results[1] || 0;
            }
        }
    }
})
