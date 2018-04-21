<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/4/2
 * Time: 11:07
 */
header('content-type:text/html;charset=utf8');
date_default_timezone_set("PRC");
$commit_pub_id=isset($_POST['commit_pub_id'])?$_POST['commit_pub_id']:'';
$commit_name=isset($_POST['commit_name'])?$_POST['commit_name']:'';
$commit_content=isset($_POST['commit_content'])?$_POST['commit_content']:'';
$commit_pic=isset($_POST['commit_pic'])?$_POST['commit_pic']:'';
if(empty($commit_pub_id) || empty($commit_name) || empty($commit_content) ||empty($commit_pic)){
    $data=array('err'=>-1,'msg'=>'参数不完整');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}
$commit_time=date('Y-m-d H:i:s');
include_once ('connect_mysql.php');
$link=conn('article');
$sq="insert into pub_commit(commit_pub_id,commit_name,commit_content,commit_pic,commit_time)VALUES ('$commit_pub_id','$commit_name','$commit_content','$commit_pic','$commit_time')";
$result=mysqli_query($link,$sq);
if(!$result){
    $data=array('err'=>0,'msg'=>'评论失败');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}
$data=array('err'=>1,'msg'=>'评论成功','commit_time'=>$commit_time);;
echo json_encode($data,JSON_UNESCAPED_UNICODE);

mysqli_close($link);
































