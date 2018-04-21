<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 17:28
 */
date_default_timezone_set("PRC");

$username=isset($_POST['username'])?$_POST['username']:'';
$password=isset($_POST['password'])?$_POST['password']:'';
$repassword=isset($_POST['repassword'])?$_POST['repassword']:'';
$verification=isset($_POST['verification'])?$_POST['verification']:'';
$data=array('err'=>0,'msg'=>'');

if(empty($username) || empty($password) || empty($repassword) || empty($verification)){
    $data=array('err'=>0,'msg'=>'信息不完整');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}

if($password!=$repassword){
    $data=array('err'=>-1,'msg'=>'密码不一致');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}

$cookie_reg=isset($_COOKIE['reg_verifi'])?$_COOKIE['reg_verifi']:'';
$verification_lower=strtolower($verification);
$cookie_reg_md5=md5($verification_lower.'gjw');
if($cookie_reg!==$cookie_reg_md5){
    $data=array('err'=>-2,'msg'=>'验证码错误');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}

include_once ('connect_mysql.php');
$link=conn('article');

$sql="select * from user where username='$username'";
$result=mysqli_query($link,$sql);
$result_num=mysqli_num_rows($result);

if($result_num!=0){
    $data=array('err'=>-3,'msg'=>'用户名已被注册');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}

$password_md5=md5($password.'gjw');
$reg_time=date('Y-m-d H:i:s');
$pic='default.jpg';
$sql="insert into user(username,password,reg_time,pic)VALUES ('$username','$password_md5','$reg_time','$pic')";
$reg_result=mysqli_query($link,$sql);
if(!$reg_result){
    $data=array('err'=>-4,'msg'=>'注册失败');
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;
}

$data=array('err'=>1,'msg'=>'注册成功');
echo json_encode($data,JSON_UNESCAPED_UNICODE);

mysqli_close($link);

























