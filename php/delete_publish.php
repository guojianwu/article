<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/31
 * Time: 15:56
 */
header('content-type:text/html;charset=utf8');
$pub_id=isset($_POST['pub_id'])?$_POST['pub_id']:'11';
if(empty($pub_id)){
    $data=array('err'=>0,'msg'=>'删除失败');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}

include_once ('connect_mysql.php');
$link=conn('article');
$sql="delete from publish where pub_id='$pub_id'";
$result=mysqli_query($link,$sql);
if(!$result){
    $data=array('err'=>-1,'msg'=>'删除失败');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}
$data=array('err'=>1,'msg'=>'删除成功');
echo json_encode($data,JSON_UNESCAPED_UNICODE);
exit;



