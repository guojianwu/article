/**
 * Created by admin on 2018/3/29.
 */
// $(function() {
//     $.get('/article/php/put_publish.php').done(function (res) {
//         var res=JSON.parse(res);
//             console.log(res);
//     })
// })
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
            var self=this;
            var currentpage=currentpage?currentpage:1;
            var pagesize=pagesize?pagesize:10;
            axios.get('/article/php/put_publish.php?currentpage='+currentpage+'&pagesize='+pagesize)
                .then(function (response) {
                    self.PublishDate=response.data;
                    self.publishCount=parseInt(response.data.count);
                    self.sub_pub_content();
                })
        },
        sub_pub_content:function () {
            for (var i=0;i<this.PublishDate.publish.length;i++){
                this.PublishDate.publish[i]['pub_content']=this.PublishDate.publish[i]['pub_content'].substring(0,1200);
            }
        },
        currentChange:function (current) {
            this.getPublishDate(current,10);
            window.scrollTo(0,0);
        }
    }
})
