<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/4/4
 * Time: 11:54
 */

$pub_privacy=isset($_POST['pub_privacy'])?$_POST['pub_privacy']:'';
$pub_id=isset($_POST['pub_id'])?$_POST['pub_id']:'';
if(empty($pub_privacy) || empty($pub_id)){
    $data=array('err'=>0,'msg'=>'参数无效');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}
include_once ('connect_mysql.php');
$link=conn('article');

$sql="update publish set pub_privacy=$pub_privacy WHERE pub_id='$pub_id'";

$result=mysqli_query($link,$sql);
if(!$result){
    $data=array('err'=>-1,'msg'=>'修改失败');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}
$data=array('err'=>1,'msg'=>'修改修改成功');
echo json_encode($data,JSON_UNESCAPED_UNICODE);
exit;