<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 11:04
 */

header('content-type:text/html;charset=utf8');
date_default_timezone_set("PRC");
include_once ('connect_mysql.php');
$link=conn('article');


$pub_name=isset($_POST['pub_name'])?$_POST['pub_name']:'';
$pub_title=isset($_POST['pub_title'])?$_POST['pub_title']:'';
$pub_type=isset($_POST['pub_type'])?$_POST['pub_type']:'';
$pub_content=isset($_POST['pub_content'])?$_POST['pub_content']:'';
$pub_privacy=isset($_POST['pub_privacy'])?$_POST['pub_privacy']:1;
$pub_content=htmlspecialchars($pub_content);
$result=array('err'=>0,'msg'=>'');
if(empty($pub_name) || empty($pub_title) || empty($pub_type) || empty($pub_content)){
    $result['err']=-1;
    $result['msg']='请填写完整';
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
    exit;
}
$pub_time=date('Y-m-d H:i:s');
$sql="insert into publish(pub_name,pub_title,pub_type,pub_content,pub_privacy,pub_time)VALUES ('$pub_name','$pub_title','$pub_type','$pub_content','$pub_privacy','$pub_time')";
$select=mysqli_query($link,$sql);
if(!$select){
    $result['err']=0;
    $result['msg']='文章发表失败';
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
    exit;
}
$result['err']=1;
$result['msg']='文章发表成功';
echo json_encode($result,JSON_UNESCAPED_UNICODE);

mysqli_close($link);







