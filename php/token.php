<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/30
 * Time: 15:14
 */

$user=isset($_COOKIE['username'])?$_COOKIE['username']:'';
$token=isset($_COOKIE['token'])?$_COOKIE['token']:'';

include_once ('connect_mysql.php');
$link=conn('article');

$sql="select user_id,username,pic from user WHERE username='$user'";
$result=mysqli_query($link,$sql);
$row=mysqli_num_rows($result);
$user_md5=md5($user.'gjw');
if($row==0 && $user_md5!=$token){
    $data=array('err'=>0,'msg'=>'用户不存在');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}

$userInfo=mysqli_fetch_assoc($result);
$data=array('err'=>'1','token'=>$token,'userInfo'=>$userInfo);
echo json_encode($data,JSON_UNESCAPED_UNICODE);


