/**
 * Created by admin on 2018/3/29.
 */
new Vue({
    el:"#app",
    data:{
        PublishDate:[],
        userInfo:'',
        commitContent:'',
        isLogin:false,
        longUrl:'javascript:void(0);',
        commitTip:'',
        pubCommitData:[],
        publishCount:0
    },
    mounted: function () {
        this.$nextTick(function () {
            this.getPublishDate();
        })
    },
    methods:{
        getPublishDate:function () {
            var param=this.urlParam("pub_id", window.location.href)
            var self=this;
            axios.get('/article/php/put_publish.php?pub_id='+param)
                .then(function (response) {
                    self.PublishDate=response.data;
                    self.getCommit();
                })
            axios.get('/article/php/token.php')
                .then(function (response) {
                    self.userInfo=response.data;
            })


        },
        getCommit:function (currentpage,pagesize) {
            var currentpage=currentpage?currentpage:1;
            var pagesize=pagesize?pagesize:10;
            var self=this;
            var param=this.urlParam("pub_id", window.location.href);
            axios.get('/article/php/put_publish_commit.php?pub_id='+param+'&currentpage='+currentpage+'&pagesize='+pagesize)
                .then(function (response) {
                    self.pubCommitData=response.data;
                    self.publishCount=parseInt(response.data.count);
                    // console.log(response.data);
                })
        },
        send_commit:function () {
           var commit_content=this.commitContent;
            if(this.userInfo.err!=1){
                this.longUrl='/article/view/login.html'
                this.commitTip='请先登录...'
                this.isLogin=true;
                return false;
            }
            var commit_pub_id=this.PublishDate.publish[0].pub_id;
            var commit_name=this.userInfo.userInfo.username;
            var commit_pic=this.userInfo.userInfo.pic;
            var commitObj={
                commit_pub_id:commit_pub_id,
                commit_name:commit_name,
                commit_content:commit_content,
                commit_pic:commit_pic
            }
            if(!commit_content){
                this.commitTip='请输入评论内容...'
                this.isLogin=true;
                return false;
            }
            var self=this;
            $.post('/article/php/pub_commit.php',{
                commit_pub_id:commit_pub_id,
                commit_name:commit_name,
                commit_content:commit_content,
                commit_pic:commit_pic
            }).done(function (res) {
                var res=JSON.parse(res);
                if(res.err==1){
                    self.commitContent='';
                    self.commitTip='评论成功...'
                    self.isLogin=true;
                    commitObj['commit_time']=res.commit_time;
                    self.pubCommitData.commit_data.unshift(commitObj);
                    self.publishCount++;
                }
            })
        },
        currentChange:function (num) {
            this.getCommit(num,10);
            window.scrollTo(0,$('.comment').offset().top-50);
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
