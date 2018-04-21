/**
 * Created by admin on 2018/3/30.
 */
new Vue({
    el:"#app",
    data:{
        PublishDate:[],
        userInfo:[],
        username:'',
        imageUrl: '',
        publishCount:0,
        user_pic:''
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
            var username= decodeURI(this.urlParam('pub_name',window.location.href));
            this.username=username;
            axios.get('/article/php/put_publish.php?pub_name='+username+'&currentpage='+currentpage+'&pagesize='+pagesize)
                .then(function (response) {
                    self.PublishDate=response.data;
                    self.user_pic='/article/avatar/'+response.data.publish[0].pic;
                    self.publishCount=parseInt(response.data.count);
                    self.sub_pub_content();
                })


        },
        delete_publish:function (id) {
            var self=this;
            this.$confirm('此操作将永久删除该日志, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(function() {
                $.post('/article/php/delete_publish.php',{
                    pub_id:id
                }).done(function (res) {
                    var res=JSON.parse(res);
                    if(res.err==1){
                        self.splice_arr(id,self.PublishDate.publish);
                    }
                });
            }).catch(function() {

            });

        },
        openPub:function (pri,pub) {
            var self=this;
            var tip=pri==1?'此操作该日志将所有人可见,是否继续？':'此操作该日志仅自己可见,是否继续？？'
            this.$confirm(tip, '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(function() {
                $.post('/article/php/change_pub_privacy.php',{
                    pub_privacy:pri,
                    pub_id:pub.pub_id
                }).done(function (res) {
                    var res=JSON.parse(res);
                    if(res.err==1){
                        pub.pub_privacy=pri;
                    }
                });
            }).catch(function() {

            });

        },
        currentChange:function (current) {
            this.getPublishDate(current,10);
            window.scrollTo(0,0);
        },
        splice_arr:function (index,arr) {
            for (var i=0;i<arr.length;i++){
                if(index==arr[i]['pub_id']){
                    arr.splice(i,1);
                    break;
                }
            }
        },
        handleAvatarSuccess:function(res, file) {
            this.imageUrl = URL.createObjectURL(file.raw);
        },
        in_arr:function (str,arr) {
            var result=false;
            for (var i=0;i<arr.length;i++){
                if(str==arr[i]){
                    result=true;
                    break;
                }
            }
            return result;
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